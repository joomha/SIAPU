<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $jenis_surat_id = $request->jenis_surat_id;

        $query = Arsip::with(['surat.warga', 'surat.jenisSurat', 'pengajuan_surat.warga', 'pengajuan_surat.jenisSurat']);

        if ($search) {
            $query->whereHas('surat.warga', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')->orWhere('nik', 'like', '%' . $search . '%');
            })->orWhereHas('pengajuan_surat.warga', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $query->whereBetween('tanggal_arsip', [$tanggal_awal, $tanggal_akhir]);
        }

        if ($jenis_surat_id) {
            $query->whereHas('surat', function($q) use ($jenis_surat_id) {
                $q->where('jenis_surat_id', $jenis_surat_id);
            })->orWhereHas('pengajuan_surat', function($q) use ($jenis_surat_id) {
                $q->where('jenis_surat_id', $jenis_surat_id);
            });
        }

        $arsips = $query->latest('tanggal_arsip')->paginate(10);
        $jenis_surats = JenisSurat::all();
        
        return view('admin.arsip.index', compact('arsips', 'jenis_surats'));
    }

    public function viewFile($id)
    {
        $arsip = Arsip::findOrFail($id);
        
        if ($arsip->lokasi_file && Storage::disk('public')->exists($arsip->lokasi_file)) {
            return response()->file(Storage::disk('public')->path($arsip->lokasi_file), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.basename($arsip->lokasi_file).'"'
            ]);
        }

        return abort(404, 'File tidak ditemukan.');
    }

    public function destroy($id)
    {
        $arsip = Arsip::findOrFail($id);
        
        if ($arsip->lokasi_file && Storage::disk('public')->exists($arsip->lokasi_file)) {
            Storage::disk('public')->delete($arsip->lokasi_file);
        }
        
        $suratId = $arsip->surat_id;
        $pengajuanId = $arsip->pengajuan_surat_id;
        
        $arsip->delete();
        
        if ($suratId) {
            $surat = \App\Models\Surat::find($suratId);
            if ($surat) {
                if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                    Storage::disk('public')->delete($surat->file_surat);
                }
                $surat->delete();
            }
        }
        
        if ($pengajuanId) {
            \App\Models\PengajuanSurat::where('id', $pengajuanId)->delete();
        }
        
        return redirect()->route('admin.arsip.index')->with('success', 'Arsip digital dan data terkait berhasil dihapus.');
    }
}
