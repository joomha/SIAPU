<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    public function index()
    {
        $jenis_surats = JenisSurat::latest()->paginate(10);
        return view('admin.jenis_surat.index', compact('jenis_surats'));
    }

    public function create()
    {
        return view('admin.jenis_surat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'template_surat' => 'nullable|string',
        ]);

        JenisSurat::create($validated);

        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function edit(JenisSurat $jenis_surat)
    {
        return view('admin.jenis_surat.edit', compact('jenis_surat'));
    }

    public function update(Request $request, JenisSurat $jenis_surat)
    {
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'template_surat' => 'nullable|string',
        ]);

        $jenis_surat->update($validated);

        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy(JenisSurat $jenis_surat)
    {
        $jenis_surat->delete();
        return redirect()->route('admin.jenis-surat.index')->with('success', 'Jenis surat berhasil dihapus.');
    }
}
