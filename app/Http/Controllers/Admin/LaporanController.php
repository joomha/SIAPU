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
        $totalPenerimaBlt = Blt::where('status_penerimaan', 'Diterima')->count();

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
}
