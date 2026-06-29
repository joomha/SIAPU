<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\Surat;
use Illuminate\Http\Request;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanSurat::with(['warga', 'jenisSurat'])->latest()->paginate(10);
        return view('admin.pengajuan_surat.index', compact('pengajuans'));
    }

    public function show(PengajuanSurat $pengajuan_surat)
    {
        return view('admin.pengajuan_surat.show', compact('pengajuan_surat'));
    }

    public function edit(PengajuanSurat $pengajuan_surat)
    {
        return view('admin.pengajuan_surat.edit', compact('pengajuan_surat'));
    }

    public function update(Request $request, PengajuanSurat $pengajuan_surat)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'catatan' => 'nullable|string',
        ]);

        $pengajuan_surat->update($validated);

        if ($validated['status'] === 'Selesai') {
            // Check if Surat already exists
            $exists = Surat::where('warga_id', $pengajuan_surat->warga_id)
                ->where('jenis_surat_id', $pengajuan_surat->jenis_surat_id)
                ->whereDate('tanggal_surat', today())
                ->first();

            if (!$exists) {
                Surat::create([
                    'warga_id' => $pengajuan_surat->warga_id,
                    'jenis_surat_id' => $pengajuan_surat->jenis_surat_id,
                    'tanggal_surat' => today(),
                    'status' => 'Menunggu Validasi',
                ]);
            }
        }

        return redirect()->route('admin.pengajuan-surat.index')->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
