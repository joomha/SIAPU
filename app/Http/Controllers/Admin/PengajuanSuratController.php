<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\Surat;
use App\Models\BukuRegisterSurat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusPengajuanMail;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanSurat::with(['warga', 'jenisSurat'])->latest()->paginate(10);
        return view('admin.pengajuan_surat.index', compact('pengajuans'));
    }

    public function show($id)
    {
        $pengajuan_surat = PengajuanSurat::with(['warga', 'jenisSurat'])->findOrFail($id);
        return view('admin.pengajuan_surat.show', compact('pengajuan_surat'));
    }

    public function edit(PengajuanSurat $pengajuan_surat)
    {
        return view('admin.pengajuan_surat.edit', compact('pengajuan_surat'));
    }

    public function preview($id)
    {
        $pengajuan = PengajuanSurat::with(['warga', 'jenisSurat'])->findOrFail($id);
        
        $viewName = 'pdf.template_' . $pengajuan->jenis_surat_id;
        
        if (!empty($pengajuan->jenisSurat->template_surat) && view()->exists($pengajuan->jenisSurat->template_surat)) {
            $viewName = $pengajuan->jenisSurat->template_surat;
        } elseif (!empty($pengajuan->jenisSurat->template_konten)) {
            $viewName = 'pdf.dynamic';
        } elseif (!view()->exists($viewName)) {
            // Fallback default view if specific template is not created yet
            $viewName = 'pdf.default'; 
        }

        $konten = '';
        if ($viewName === 'pdf.dynamic') {
            $konten = $this->parseTemplate($pengajuan->jenisSurat->template_konten, $pengajuan);
        }
        
        // Requires dompdf. Use a dummy HTML if PDF isn't installed yet
        if (class_exists(Pdf::class) && view()->exists($viewName)) {
            $pdf = Pdf::loadView($viewName, compact('pengajuan', 'konten'));
            return $pdf->stream('preview_surat.pdf');
        }

        return response("PDF package (barryvdh/laravel-dompdf) or view not found.", 404);
    }

    public function validasi(Request $request, $id)
    {
        $pengajuan_surat = PengajuanSurat::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Perlu Revisi,Selesai,Ditolak,Menunggu Kades',
            'catatan_admin' => 'nullable|string',
        ]);

        if ($validated['status'] === 'Selesai' && !$pengajuan_surat->nomor_surat) {
            $tahun = date('Y');
            $register = BukuRegisterSurat::firstOrCreate(
                ['jenis_surat_id' => $pengajuan_surat->jenis_surat_id, 'tahun' => $tahun]
            );
            
            $register->nomor_terakhir += 1;
            $register->save();
            
            $jenisSurat = $pengajuan_surat->jenisSurat;
            $kode = $jenisSurat->kode_surat ?? '470';
            $format = $jenisSurat->format_nomor ?? '[KODE]/[NOMOR]/DS/[TAHUN]';
            
            $nomorSurat = str_replace(
                ['[KODE]', '[NOMOR]', '[TAHUN]'],
                [$kode, str_pad($register->nomor_terakhir, 3, '0', STR_PAD_LEFT), $tahun],
                $format
            );
            
            $validated['nomor_surat'] = $nomorSurat;
        }

        if ($validated['status'] === 'Selesai' && !$pengajuan_surat->kode_verifikasi) {
            $validated['kode_verifikasi'] = \Illuminate\Support\Str::random(12);
        }

        $pengajuan_surat->update($validated);
        
        activity()
            ->performedOn($pengajuan_surat)
            ->causedBy(auth()->user())
            ->log('Admin memvalidasi pengajuan surat menjadi status: ' . $validated['status']);

        // Send Email Notification
        $pengajuan_surat->load('warga.user'); // Eager load relationships
        $emailTujuan = $pengajuan_surat->warga->email 
            ?? ($pengajuan_surat->warga->user->email ?? null);
        
        if (!$emailTujuan || str_ends_with($emailTujuan, '@desa.local')) {
            $emailTujuan = 'admin@desakadubeureum.digital'; // Fallback
        }
        
        try {
            Mail::to($emailTujuan)->send(new StatusPengajuanMail($pengajuan_surat));
            \Log::info('Email notifikasi status surat berhasil dikirim ke: ' . $emailTujuan . ' | Status: ' . $pengajuan_surat->status . ' | Pengajuan ID: ' . $pengajuan_surat->id);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi ke ' . $emailTujuan . ': ' . $e->getMessage());
        }

        // Send WhatsApp Notification
        if (!empty($pengajuan_surat->warga->telepon)) {
            $pesan = "Halo {$pengajuan_surat->warga->nama},\n\nStatus pengajuan surat Anda ({$pengajuan_surat->jenisSurat->nama_surat}) telah diperbarui menjadi: *{$pengajuan_surat->status}*.\n";
            if ($pengajuan_surat->catatan_admin) {
                $pesan .= "Catatan: {$pengajuan_surat->catatan_admin}\n";
            }
            if ($pengajuan_surat->kode_verifikasi) {
                $pesan .= "\nKode Verifikasi: {$pengajuan_surat->kode_verifikasi}\nCek validitas surat di: " . url('/verify/' . $pengajuan_surat->kode_verifikasi);
            }
            $pesan .= "\n\nTerima Kasih,\nPemerintah Desa Kadubeureum";
            
            \App\Jobs\SendWhatsAppJob::dispatch($pengajuan_surat->warga->telepon, $pesan);
        }

        return redirect()->route('admin.pengajuan-surat.index')->with('success', 'Status pengajuan berhasil diperbarui dan notifikasi email dikirim ke ' . $emailTujuan . '.');
    }
    private function parseTemplate($template, $pengajuan)
    {
        $warga = $pengajuan->warga;
        $tanggal_lahir = $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y') : '-';
        
        // Extract data form isian
        $isian = is_array($pengajuan->data_isian) ? $pengajuan->data_isian : json_decode($pengajuan->data_isian, true) ?? [];
        
        $replaces = [
            '{{ $warga->nama }}' => $warga->nama,
            '{{ $warga->nik }}' => $warga->nik,
            '{{ $warga->nomor_kk }}' => $warga->nomor_kk ?? '-',
            '{{ $warga->tempat_lahir }}' => $warga->tempat_lahir ?? '-',
            '{{ $warga->tanggal_lahir }}' => $tanggal_lahir,
            '{{ $warga->jenis_kelamin }}' => $warga->jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan',
            '{{ $warga->agama }}' => $warga->agama ?? '-',
            '{{ $warga->pekerjaan }}' => $warga->pekerjaan ?? '-',
            '{{ $warga->alamat }}' => $warga->alamat ?? '-',
            '{{ $warga->rt }}' => $warga->rt ?? '-',
            '{{ $warga->rw }}' => $warga->rw ?? '-',
            '{{ $warga->telepon }}' => $warga->telepon ?? '-',
            '{{ $pengajuan->nomor_surat }}' => $pengajuan->nomor_surat ?? '[BELUM ADA NOMOR]',
            '{{ $tanggal_hari_ini }}' => \Carbon\Carbon::now()->translatedFormat('d F Y'),
            '{{ $kepala_desa }}' => config('settings.kades_nama', '....................'),
            '{{ $nip_kepala_desa }}' => config('settings.kades_nip', '....................'),
        ];

        // Replace for each field in form_isian
        foreach ($isian as $key => $value) {
            $replaces['{{ $isian[\''.$key.'\'] }}'] = $value;
        }

        return str_replace(array_keys($replaces), array_values($replaces), $template);
    }

    public function getNotifCount()
    {
        $role = auth()->user()->role;
        $count = 0;
        if ($role === 'admin') {
            $count = \App\Models\PengajuanSurat::where('status', 'Menunggu')->count();
        } elseif ($role === 'validator') {
            $count = \App\Models\PengajuanSurat::where('status', 'Menunggu Kades')->count();
        }
        return response()->json(['count' => $count]);
    }
}
