<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\PengajuanSurat;
use App\Models\JenisSurat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Metric boxes
        $totalWarga = Warga::count();
        $totalPengajuan = PengajuanSurat::count();
        $pengajuanSelesai = PengajuanSurat::where('status', 'Selesai')->count();
        $pengajuanMenunggu = PengajuanSurat::whereIn('status', ['Menunggu', 'Validasi'])->count();
        $pengajuanDitolak = PengajuanSurat::where('status', 'Ditolak')->count();

        // Chart Data (Last 6 months)
        $chartData = [];
        $chartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::today()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('F Y');
            
            $count = PengajuanSurat::whereYear('tanggal_pengajuan', $month->year)
                ->whereMonth('tanggal_pengajuan', $month->month)
                ->count();
            $chartData[] = $count;
        }

        // Popular Jenis Surat
        $popularSurats = PengajuanSurat::select('jenis_surat_id', DB::raw('count(*) as total'))
            ->groupBy('jenis_surat_id')
            ->orderByDesc('total')
            ->take(5)
            ->with('jenisSurat')
            ->get();

        // Activity Log (Last 5 actions)
        $activities = \Spatie\Activitylog\Models\Activity::with('causer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalWarga', 
            'totalPengajuan', 
            'pengajuanSelesai', 
            'pengajuanMenunggu', 
            'pengajuanDitolak',
            'chartLabels',
            'chartData',
            'popularSurats',
            'activities'
        ));
    }
}
