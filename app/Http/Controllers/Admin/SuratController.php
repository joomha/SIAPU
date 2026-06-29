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
            $pdf = Pdf::loadView('admin.surat.template_default', compact('surat'));
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
}
