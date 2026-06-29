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
        ]);

        // Find or create Warga
        $warga = Warga::where('nik', $validated['nik'])->first();
        if (!$warga) {
            $warga = Warga::create([
                'nik' => $validated['nik'],
                'nama' => $validated['nama'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'pekerjaan' => $validated['pekerjaan'],
                'status_perkawinan' => $validated['status_perkawinan'],
            ]);
        } else {
            // Update their info just in case
            $warga->update([
                'nama' => $validated['nama'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'pekerjaan' => $validated['pekerjaan'],
                'status_perkawinan' => $validated['status_perkawinan'],
            ]);
        }

        // Create Pengajuan
        $pengajuan = PengajuanSurat::create([
            'warga_id' => $warga->id,
            'jenis_surat_id' => $validated['jenis_surat_id'],
            'tanggal_pengajuan' => today(),
            'status' => 'Menunggu',
        ]);

        return redirect()->route('public.cek_status')->with('success', 'Pengajuan berhasil dikirim! Silakan cek status secara berkala dengan menggunakan NIK Anda.');
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
}
