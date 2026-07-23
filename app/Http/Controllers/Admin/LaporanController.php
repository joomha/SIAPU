<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Models\Surat;
use App\Models\PengajuanSurat;
use App\Models\Blt;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $totalWarga = Warga::count();
        $totalSuratDibuat = Surat::count();
        $pengajuanMenunggu = PengajuanSurat::where('status', 'Menunggu')->count();
        $suratMenungguValidasi = Surat::where('status', 'Menunggu Validasi')->count();
        $totalPenerimaBlt = Blt::where('status_penerima', 'Diterima')->count();

        // Optional: group by gender
        $wargaLaki = Warga::where('jenis_kelamin', 'Laki-Laki')->count();
        $wargaPerempuan = Warga::where('jenis_kelamin', 'Perempuan')->count();

        return view('admin.laporan.index', compact(
            'totalWarga', 
            'totalSuratDibuat', 
            'pengajuanMenunggu', 
            'suratMenungguValidasi', 
            'totalPenerimaBlt',
            'wargaLaki',
            'wargaPerempuan'
        ));
    }

    public function exportExcel()
    {
        $pengajuans = PengajuanSurat::with(['warga', 'jenisSurat'])->latest()->get();

        $data = [
            ['ID', 'Tanggal', 'Pemohon', 'NIK', 'Jenis Surat', 'Status', 'Nomor Surat']
        ];

        foreach ($pengajuans as $p) {
            $data[] = [
                $p->id,
                \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('Y-m-d'),
                $p->warga->nama,
                "'" . $p->warga->nik, // Prefix with apostrophe for Excel to treat as string
                $p->jenisSurat->nama_surat,
                $p->status,
                $p->nomor_surat ?? '-'
            ];
        }

        $xlsx = \Shuchkin\SimpleXLSXGen::fromArray($data);
        $xlsx->downloadAs('laporan_pengajuan_surat.xlsx');
        exit;
    }

    public function exportPdf()
    {
        $pengajuans = PengajuanSurat::with(['warga', 'jenisSurat'])->latest()->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', compact('pengajuans'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan_pengajuan_surat.pdf');
    }
}
