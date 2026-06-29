<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blt;
use App\Models\Warga;
use Illuminate\Http\Request;

class BltController extends Controller
{
    public function index()
    {
        $blts = Blt::with('warga')->latest()->paginate(10);
        return view('admin.blt.index', compact('blts'));
    }

    public function create()
    {
        $wargas = Warga::all();
        return view('admin.blt.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'periode' => 'required|string|max:255',
            'status_penerimaan' => 'required|in:Layak,Tidak Layak,Diterima',
        ]);

        Blt::create($validated);

        return redirect()->route('admin.blt.index')->with('success', 'Data BLT berhasil ditambahkan.');
    }

    public function edit(Blt $blt)
    {
        $wargas = Warga::all();
        return view('admin.blt.edit', compact('blt', 'wargas'));
    }

    public function update(Request $request, Blt $blt)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'periode' => 'required|string|max:255',
            'status_penerimaan' => 'required|in:Layak,Tidak Layak,Diterima',
        ]);

        $blt->update($validated);

        return redirect()->route('admin.blt.index')->with('success', 'Data BLT berhasil diperbarui.');
    }

    public function destroy(Blt $blt)
    {
        $blt->delete();
        return redirect()->route('admin.blt.index')->with('success', 'Data BLT berhasil dihapus.');
    }
}
