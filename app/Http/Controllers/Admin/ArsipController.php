<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::with(['surat.warga', 'surat.jenisSurat']);
        
        if ($request->has('search')) {
            $query->whereHas('surat.warga', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        }

        $arsips = $query->latest()->paginate(10);
        return view('admin.arsip.index', compact('arsips'));
    }

    public function destroy(Arsip $arsip)
    {
        if (Storage::disk('public')->exists($arsip->lokasi_file)) {
            Storage::disk('public')->delete($arsip->lokasi_file);
        }
        $arsip->delete();
        return redirect()->route('admin.arsip.index')->with('success', 'Arsip digital berhasil dihapus.');
    }
}
