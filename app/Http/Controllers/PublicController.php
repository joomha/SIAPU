<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\Warga;
use App\Models\PengajuanSurat;


class PublicController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function layananMandiri()
    {
        $jenis_surats = JenisSurat::all();
        return view('public.layanan_mandiri', compact('jenis_surats'));
    }

    public function storePengajuan(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'pekerjaan' => 'required|string|max:255',
            'status_perkawinan' => 'required|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'email' => 'required|email',
            'data_isian' => 'nullable|array',
        ]);

        // Cek apakah NIK terdaftar sebagai warga desa
        $warga = Warga::where('nik', $validated['nik'])->first();
        if (!$warga) {
            return redirect()->back()
                ->withInput()
                ->with('nik_error', 'NIK ' . $validated['nik'] . ' tidak terdaftar sebagai warga Desa Kadubeureum. Silakan hubungi kantor desa untuk mendaftarkan diri terlebih dahulu.');
        }

        // Update data warga jika ada perubahan
        $warga->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'],
            'rt' => $validated['rt'],
            'rw' => $validated['rw'],
            'pekerjaan' => $validated['pekerjaan'],
            'status_perkawinan' => $validated['status_perkawinan'],
        ]);

        // Create Pengajuan
        $pengajuan = PengajuanSurat::create([
            'warga_id' => $warga->id,
            'jenis_surat_id' => $validated['jenis_surat_id'],
            'tanggal_pengajuan' => today(),
            'data_isian' => $validated['data_isian'] ?? null,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('public.cek_status')->with('success', 'Pengajuan berhasil dikirim! Silakan cek status secara berkala dengan menggunakan NIK Anda.');
    }

    public function getFormIsian($id)
    {
        $jenisSurat = JenisSurat::find($id);
        if ($jenisSurat) {
            return response()->json(['form_isian' => $jenisSurat->form_isian]);
        }
        return response()->json(['form_isian' => null], 404);
    }

    public function cekStatus(Request $request)
    {
        $pengajuans = collect();

        if ($request->has('nik')) {
            $request->validate([
                'nik' => 'required|string|size:16',
            ]);

            $warga = Warga::where('nik', $request->nik)->first();

            if ($warga) {
                $pengajuans = PengajuanSurat::with('jenisSurat')
                    ->where('warga_id', $warga->id)
                    ->latest()
                    ->get();
            } else {
                return back()->with('error', 'NIK tidak ditemukan dalam sistem kami.');
            }
        }

        return view('public.cek_status', compact('pengajuans'));
    }

    public function verifyQr($kode)
    {
        $pengajuan = PengajuanSurat::with(['warga', 'jenisSurat'])
            ->where('kode_verifikasi', $kode)
            ->where('status', 'Selesai')
            ->first();

        if (!$pengajuan) {
            return view('public.verify_qr', ['valid' => false]);
        }

        return view('public.verify_qr', [
            'valid' => true,
            'pengajuan' => $pengajuan
        ]);
    }
}
