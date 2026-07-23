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

        // Query Surat
        $qSurat = \App\Models\Surat::with(['warga', 'jenisSurat'])->where('status', 'Disetujui');
        
        // Query PengajuanSurat
        $qPengajuan = \App\Models\PengajuanSurat::with(['warga', 'jenisSurat'])->where('status', 'Selesai');

        if ($search) {
            $qSurat->whereHas('warga', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')->orWhere('nik', 'like', '%' . $search . '%');
            });
            $qPengajuan->whereHas('warga', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $qSurat->whereBetween('updated_at', [$tanggal_awal . ' 00:00:00', $tanggal_akhir . ' 23:59:59']);
            $qPengajuan->whereBetween('updated_at', [$tanggal_awal . ' 00:00:00', $tanggal_akhir . ' 23:59:59']);
        }

        if ($jenis_surat_id) {
            $qSurat->where('jenis_surat_id', $jenis_surat_id);
            $qPengajuan->where('jenis_surat_id', $jenis_surat_id);
        }

        $surats = $qSurat->get();
        $pengajuans = $qPengajuan->get();

        $allArsip = $surats->map(function($item) {
            return (object)[
                'id' => $item->id,
                'type' => 'surat',
                'tanggal_arsip' => $item->updated_at->format('Y-m-d'),
                'nomor_surat' => $item->nomor_surat,
                'warga' => $item->warga,
                'jenisSurat' => $item->jenisSurat,
                'lokasi_file' => $item->file_surat,
                'is_file' => true,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ];
        })->concat($pengajuans->map(function($item) {
            return (object)[
                'id' => $item->id,
                'type' => 'pengajuan',
                'tanggal_arsip' => $item->updated_at->format('Y-m-d'),
                'nomor_surat' => $item->nomor_surat,
                'warga' => $item->warga,
                'jenisSurat' => $item->jenisSurat,
                'lokasi_file' => null,
                'is_file' => false,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ];
        }))->sortByDesc('updated_at')->values();

        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $allArsip->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $arsips = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $allArsip->count(), $perPage, $currentPage, [
            'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query()
        ]);

        $jenis_surats = JenisSurat::all();
        
        return view('admin.arsip.index', compact('arsips', 'jenis_surats'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->type === 'surat') {
            $surat = \App\Models\Surat::findOrFail($id);
            if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                Storage::disk('public')->delete($surat->file_surat);
            }
            $surat->delete();
            // Delete associated arsip table record just in case it exists
            \App\Models\Arsip::where('surat_id', $id)->delete();
        } elseif ($request->type === 'pengajuan') {
            \App\Models\PengajuanSurat::findOrFail($id)->delete();
        }
        return redirect()->route('admin.arsip.index')->with('success', 'Arsip digital berhasil dihapus.');
    }
}
