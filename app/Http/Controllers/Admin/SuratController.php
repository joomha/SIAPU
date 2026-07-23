<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\Arsip;
use App\Models\Warga;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    public function index()
    {
        $surats = Surat::with(['warga', 'jenisSurat'])->latest()->paginate(10);
        return view('admin.surat.index', compact('surats'));
    }

    public function create()
    {
        $wargas = Warga::all();
        $jenis_surats = JenisSurat::all();
        return view('admin.surat.create', compact('wargas', 'jenis_surats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
        ]);

        $validated['tanggal_surat'] = today();
        $validated['status'] = 'Draft';

        Surat::create($validated);

        return redirect()->route('admin.surat.index')->with('success', 'Draft surat berhasil dibuat.');
    }

    public function edit(Surat $surat)
    {
        return view('admin.surat.edit', compact('surat'));
    }

    public function update(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'status' => 'required|in:Draft,Menunggu Validasi,Disetujui,Ditolak',
        ]);

        if ($validated['status'] == 'Disetujui' && $surat->status != 'Disetujui') {
            // Generate nomor surat if null
            if (!$surat->nomor_surat) {
                $surat->nomor_surat = 'SRT/' . date('Y/m/') . str_pad($surat->id, 4, '0', STR_PAD_LEFT);
            }

            // Generate PDF
            $viewName = 'pdf.template_' . $surat->jenis_surat_id;
            if (!empty($surat->jenisSurat->template_surat) && view()->exists($surat->jenisSurat->template_surat)) {
                $viewName = $surat->jenisSurat->template_surat;
            } elseif (!empty($surat->jenisSurat->template_konten)) {
                $viewName = 'pdf.dynamic';
            } elseif (!view()->exists($viewName)) {
                $viewName = 'admin.surat.template_default'; 
            }

            $konten = '';
            if ($viewName === 'pdf.dynamic') {
                $konten = $this->parseTemplate($surat->jenisSurat->template_konten, $surat);
            }

            $pdf = Pdf::loadView($viewName, compact('surat', 'konten'));
            $fileName = 'surat_' . Str::slug($surat->warga->nama) . '_' . time() . '.pdf';
            $path = 'arsip/' . $fileName;
            Storage::disk('public')->put($path, $pdf->output());

            $surat->file_surat = $path;
            
            // Auto Archive
            Arsip::create([
                'surat_id' => $surat->id,
                'lokasi_file' => $path,
                'tanggal_arsip' => today(),
            ]);
        }

        $surat->update($validated);

        return redirect()->route('admin.surat.index')->with('success', 'Status surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat)
    {
        $surat->delete();
        return redirect()->route('admin.surat.index')->with('success', 'Surat berhasil dihapus.');
    }

    public function download(Surat $surat)
    {
        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            return Storage::disk('public')->download($surat->file_surat);
        }
        return back()->with('error', 'File PDF tidak ditemukan.');
    }
    private function parseTemplate($template, $surat)
    {
        $warga = $surat->warga;
        $tanggal_lahir = $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y') : '-';
        
        // Extract data form isian
        $isian = is_array($surat->data_isian) ? $surat->data_isian : json_decode($surat->data_isian, true) ?? [];
        
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
            '{{ $pengajuan->nomor_surat }}' => $surat->nomor_surat ?? '[BELUM ADA NOMOR]', // using $pengajuan tag for backward compat
            '{{ $tanggal_hari_ini }}' => \Carbon\Carbon::now()->translatedFormat('d F Y'),
            '{{ $kepala_desa }}' => config('settings.kades_nama', '....................'),
            '{{ $nip_kepala_desa }}' => config('settings.kades_nip', '....................'),
        ];

        foreach ($isian as $key => $value) {
            $replaces['{{ $isian[\''.$key.'\'] }}'] = $value;
        }

        return str_replace(array_keys($replaces), array_values($replaces), $template);
    }
}
