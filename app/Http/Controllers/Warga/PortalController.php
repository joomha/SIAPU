<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    public function index()
    {
        $wargaId = auth()->user()->warga_id;
        $riwayat = PengajuanSurat::with('jenisSurat')->where('warga_id', $wargaId)->latest()->get();
        return view('warga.portal.index', compact('riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'file_persyaratan.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'data_isian' => 'nullable|array',
        ]);

        $wargaId = auth()->user()->warga_id;
        $warga = \App\Models\Warga::find($wargaId);
        $jenisSurat = \App\Models\JenisSurat::find($request->jenis_surat_id);
        
        $filePaths = [];
        if ($request->hasFile('file_persyaratan')) {
            foreach ($request->file('file_persyaratan') as $file) {
                $filePaths[] = $file->store('persyaratan', 'public');
            }
        }

        // Merge documents from profile if required by the letter type
        if ($jenisSurat && is_array($jenisSurat->persyaratan_dokumen)) {
            $reqLower = array_map('strtolower', $jenisSurat->persyaratan_dokumen);
            
            $hasReq = function($str) use ($reqLower) {
                foreach ($reqLower as $req) {
                    if (str_contains($req, $str)) return true;
                }
                return false;
            };

            if ($hasReq('ktp') && $warga->file_ktp) {
                $filePaths[] = $warga->file_ktp;
            }
            if ($hasReq('kk') && $warga->file_kk) {
                $filePaths[] = $warga->file_kk;
            }
            if (($hasReq('akta lahir') || $hasReq('akta kelahiran')) && $warga->file_akta_kelahiran) {
                $filePaths[] = $warga->file_akta_kelahiran;
            }
            if ($hasReq('npwp') && $warga->file_npwp) {
                $filePaths[] = $warga->file_npwp;
            }
            if (($hasReq('pas foto') || $hasReq('pas photo') || $hasReq('foto')) && $warga->file_foto) {
                $filePaths[] = $warga->file_foto;
            }
            if ($hasReq('ijazah') && $warga->file_ijazah) {
                $filePaths[] = $warga->file_ijazah;
            }
        }

        $pengajuan = PengajuanSurat::create([
            'warga_id' => $wargaId,
            'jenis_surat_id' => $request->jenis_surat_id,
            'tanggal_pengajuan' => today(),
            'file_persyaratan' => $filePaths,
            'data_isian' => $request->data_isian,
            'status' => 'Menunggu',
        ]);

        activity()
            ->performedOn($pengajuan)
            ->causedBy(auth()->user())
            ->log('Warga mengajukan surat ' . $pengajuan->jenisSurat->nama_surat);

        return redirect()->route('warga.dashboard')->with('success', 'Surat berhasil diajukan. Surat akan dikirim ke email Anda setelah diverifikasi oleh Kepala Desa.');
    }

    public function updateRevisi(Request $request, $id)
    {
        $pengajuan = PengajuanSurat::where('id', $id)->where('warga_id', auth()->user()->warga_id)->firstOrFail();
        
        $request->validate([
            'file_persyaratan.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePaths = $pengajuan->file_persyaratan ?? [];
        
        if ($request->hasFile('file_persyaratan')) {
            // Option to delete old files could go here
            $filePaths = []; // resetting for simplicity, or appending
            foreach ($request->file('file_persyaratan') as $file) {
                $filePaths[] = $file->store('persyaratan', 'public');
            }
        }

        $pengajuan->update([
            'file_persyaratan' => $filePaths,
            'data_isian' => $request->data_isian ?? $pengajuan->data_isian,
            'status' => 'Menunggu', // back to queue
            'catatan_admin' => null,
        ]);

        activity()
            ->performedOn($pengajuan)
            ->causedBy(auth()->user())
            ->log('Warga memperbaiki berkas surat ' . $pengajuan->jenisSurat->nama_surat);

        return redirect()->route('warga.dashboard')->with('success', 'Revisi berkas berhasil dikirim.');
    }

    public function getFormIsian($id)
    {
        $jenisSurat = JenisSurat::find($id);
        if ($jenisSurat) {
            return response()->json([
                'form_isian' => $jenisSurat->form_isian,
                'persyaratan_dokumen' => $jenisSurat->persyaratan_dokumen
            ]);
        }
        return response()->json(['form_isian' => null, 'persyaratan_dokumen' => null], 404);
    }

    public function profil()
    {
        $warga = \App\Models\Warga::find(auth()->user()->warga_id);
        return view('warga.portal.profil', compact('warga'));
    }

    public function updateProfil(Request $request)
    {
        $warga = \App\Models\Warga::find(auth()->user()->warga_id);
        
        $request->validate([
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $fields = [
            'file_ktp', 'file_kk', 'file_akta_kelahiran', 
            'file_npwp', 'file_foto', 'file_ijazah'
        ];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                if ($warga->$field) {
                    Storage::disk('public')->delete($warga->$field);
                }
                $warga->$field = $request->file($field)->store('dokumen_warga', 'public');
            }
        }

        $warga->save();

        return redirect()->route('warga.profil')->with('success', 'Profil dan dokumen berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Sandi saat ini salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Sandi berhasil diperbarui.');
    }
}
