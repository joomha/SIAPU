<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\BukuRegisterSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusPengajuanMail;

class ApprovalController extends Controller
{
    public function index()
    {
        $antrean = PengajuanSurat::with(['warga', 'jenisSurat'])
            ->where('status', 'Menunggu Kades')
            ->latest()
            ->paginate(10);
            
        return view('kades.dashboard', compact('antrean'));
    }

    public function approve(Request $request, $id)
    {
        $pengajuan = PengajuanSurat::where('status', 'Menunggu Kades')->findOrFail($id);

        if ($request->action === 'Tolak') {
            $pengajuan->update([
                'status' => 'Perlu Revisi',
                'catatan_admin' => $request->catatan_admin ?? 'Ditolak Kades'
            ]);
            
            activity()
                ->performedOn($pengajuan)
                ->causedBy(auth()->user())
                ->log('Kades menolak pengajuan surat (dikembalikan untuk revisi)');
            
            $this->sendNotification($pengajuan);
            
            return redirect()->back()->with('success', 'Surat dikembalikan untuk revisi.');
        }

        // Approve (Setujui)
        
        // Approve (Setujui)
        if ($pengajuan->jenisSurat->jenis_validasi === 'tte_kades') {
            // Mock BSrE Passphrase Validation
            $passphrase = $request->input('passphrase');
            if (!$passphrase) {
                return redirect()->back()->with('error', 'Passphrase BSrE wajib diisi untuk melakukan Tanda Tangan Elektronik.');
            }
            
            // Dalam implementasi nyata, $passphrase ini akan dikirim ke API BSrE
            // $bsreResponse = Http::post('https://api.bsre.go.id/sign', ['passphrase' => $passphrase, ...]);
            if ($passphrase !== '123456') { // Mock check
                return redirect()->back()->with('error', 'Passphrase Sertifikat Elektronik salah. TTE gagal.');
            }
        }

        if (!$pengajuan->nomor_surat) {
            $tahun = date('Y');
            $register = BukuRegisterSurat::firstOrCreate(
                ['jenis_surat_id' => $pengajuan->jenis_surat_id, 'tahun' => $tahun]
            );
            
            $register->nomor_terakhir += 1;
            $register->save();
            
            $jenisSurat = $pengajuan->jenisSurat;
            $kode = $jenisSurat->kode_surat ?? '470';
            $format = $jenisSurat->format_nomor ?? '[KODE]/[NOMOR]/DS/[TAHUN]';
            
            $nomorSurat = str_replace(
                ['[KODE]', '[NOMOR]', '[TAHUN]'],
                [$kode, str_pad($register->nomor_terakhir, 3, '0', STR_PAD_LEFT), $tahun],
                $format
            );
            
            $pengajuan->nomor_surat = $nomorSurat;
        }

        $pengajuan->status = 'Selesai';
        if (!$pengajuan->kode_verifikasi) {
            $pengajuan->kode_verifikasi = \Illuminate\Support\Str::random(12);
        }
        $pengajuan->save();

        $logMessage = 'Kades menyetujui pengajuan surat';
        $flashMessage = 'Surat berhasil disetujui dan notifikasi dikirim.';
        
        if ($pengajuan->jenisSurat->jenis_validasi === 'tte_kades') {
            $logMessage .= ' (TTE Diterapkan)';
            $flashMessage = 'Surat berhasil disetujui (TTE Diterapkan) dan notifikasi dikirim.';
        }

        activity()
            ->performedOn($pengajuan)
            ->causedBy(auth()->user())
            ->log($logMessage);

        $this->sendNotification($pengajuan);

        return redirect()->back()->with('success', $flashMessage);
    }

    private function sendNotification($pengajuan)
    {
        $pengajuan->load('warga.user'); // Eager load
        $emailTujuan = $pengajuan->warga->email 
            ?? ($pengajuan->warga->user->email ?? null);
        
        if (!$emailTujuan || str_ends_with($emailTujuan, '@desa.local')) {
            $emailTujuan = 'admin@desakadubeureum.digital'; // Fallback
        }
        
        try {
            Mail::to($emailTujuan)->send(new StatusPengajuanMail($pengajuan));
            \Log::info('Email notifikasi TTE berhasil dikirim ke: ' . $emailTujuan . ' | Status: ' . $pengajuan->status . ' | Pengajuan ID: ' . $pengajuan->id);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email notifikasi ke ' . $emailTujuan . ': ' . $e->getMessage());
        }

        // Send WhatsApp Notification
        if (!empty($pengajuan->warga->telepon)) {
            $pesan = "Halo {$pengajuan->warga->nama},\n\nStatus pengajuan surat Anda ({$pengajuan->jenisSurat->nama_surat}) telah diperbarui menjadi: *{$pengajuan->status}*.\n";
            if ($pengajuan->catatan_admin) {
                $pesan .= "Catatan Kades: {$pengajuan->catatan_admin}\n";
            }
            if ($pengajuan->kode_verifikasi) {
                $pesan .= "\nKode Verifikasi: {$pengajuan->kode_verifikasi}\nCek validitas surat di: " . url('/verify/' . $pengajuan->kode_verifikasi);
            }
            $pesan .= "\n\nTerima Kasih,\nPemerintah Desa Kadubeureum";
            
            \App\Jobs\SendWhatsAppJob::dispatch($pengajuan->warga->telepon, $pesan);
        }
    }
}
