<x-app-layout>
    <x-slot name="header">Laporan & Statistik</x-slot>

    <div class="stats-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px;">
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF;">
                <svg fill="none" stroke="#2563EB" viewBox="0 0 24 24" style="width:22px;height:22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $totalWarga }}</div>
                <div class="stat-label">Total Warga</div>
                <div style="font-size:11px;color:#94A3B8;margin-top:4px;">L: {{ $wargaLaki }} &nbsp;|&nbsp; P: {{ $wargaPerempuan }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#F0FDF4;">
                <svg fill="none" stroke="#16A34A" viewBox="0 0 24 24" style="width:22px;height:22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $totalSuratDibuat }}</div>
                <div class="stat-label">Surat Diterbitkan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#FFFBEB;">
                <svg fill="none" stroke="#D97706" viewBox="0 0 24 24" style="width:22px;height:22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $pengajuanMenunggu }}</div>
                <div class="stat-label">Pengajuan Menunggu</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#F5F3FF;">
                <svg fill="none" stroke="#7C3AED" viewBox="0 0 24 24" style="width:22px;height:22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $suratMenungguValidasi }}</div>
                <div class="stat-label">Menunggu Validasi</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#FFF7ED;">
                <svg fill="none" stroke="#EA580C" viewBox="0 0 24 24" style="width:22px;height:22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="stat-value">{{ $totalPenerimaBlt }}</div>
                <div class="stat-label">Penerima Bantuan</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Cetak Laporan</h3>
        </div>
        <div class="card-body">
            <p style="color:#64748B;font-size:13.5px;margin-bottom:16px;">Cetak rekapitulasi data administrasi desa dalam format PDF. Fitur ini sedang dalam pengembangan.</p>
            <button disabled class="btn btn-ghost" style="opacity:0.5;cursor:not-allowed;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan PDF (Segera Hadir)
            </button>
        </div>
    </div>

</x-app-layout>
