<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 28px; }
        .qa-card {
            background: #fff; border-radius: 14px; padding: 20px;
            border: 1px solid #E2E8F0; text-decoration: none;
            display: flex; align-items: center; gap: 14px;
            transition: all 0.15s; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .qa-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); transform: translateY(-2px); border-color: #BFDBFE; }
        .qa-icon { width: 44px; height: 44px; border-radius: 11px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .qa-icon svg { width: 20px; height: 20px; }
        .qa-label { font-size: 13px; font-weight: 700; color: #0F172A; }
        .qa-sub { font-size: 11.5px; color: #94A3B8; margin-top: 2px; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }
        .welcome-banner {
            background: linear-gradient(135deg, #1E3A5F 0%, #0B1F3A 100%);
            border-radius: 16px; padding: 28px 32px; margin-bottom: 24px;
            display: flex; align-items: center; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .welcome-banner::after {
            content: '';
            position: absolute; right: -30px; top: -30px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(59,130,246,0.1);
        }
        .welcome-banner h1 { color: #fff; font-size: 20px; font-weight: 800; margin-bottom: 4px; }
        .welcome-banner p { color: rgba(255,255,255,0.5); font-size: 13px; }
        .welcome-date {
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; padding: 10px 16px; text-align: right; flex-shrink: 0; position: relative; z-index: 1;
        }
        .welcome-date strong { display: block; color: #fff; font-size: 18px; font-weight: 800; }
        .welcome-date span { color: rgba(255,255,255,0.45); font-size: 11px; }
    </style>

    <div class="welcome-banner">
        <div>
            <h1>Halo, {{ Auth::user()->name }} 👋</h1>
            <p>Selamat datang di Panel Admin SIAPU &mdash; Desa Kadubeureum</p>
        </div>
        <div class="welcome-date">
            <strong>{{ date('d') }}</strong>
            <span>{{ date('M Y') }}</span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF;">
                <svg fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <div class="stat-value" id="stat-warga">—</div>
                <div class="stat-label">Total Warga Terdaftar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#F0FDF4;">
                <svg fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <div class="stat-value" id="stat-surat">—</div>
                <div class="stat-label">Surat Diterbitkan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFFBEB;">
                <svg fill="none" stroke="#D97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="stat-value" id="stat-pending">—</div>
                <div class="stat-label">Pengajuan Menunggu</div>
            </div>
        </div>

    </div>

    <p style="font-size:13px;font-weight:700;color:#0F172A;margin-bottom:14px;">Akses Cepat</p>
    <div class="quick-actions">
        <a href="{{ route('admin.warga.index') }}" class="qa-card">
            <div class="qa-icon" style="background:#EFF6FF;"><svg fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
            <div><div class="qa-label">Data Warga</div><div class="qa-sub">Kelola data penduduk</div></div>
        </a>
        <a href="{{ route('admin.surat.index') }}" class="qa-card">
            <div class="qa-icon" style="background:#F0FDF4;"><svg fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
            <div><div class="qa-label">Surat Administrasi</div><div class="qa-sub">Buat & kelola surat</div></div>
        </a>
        <a href="{{ route('admin.pengajuan-surat.index') }}" class="qa-card">
            <div class="qa-icon" style="background:#FFFBEB;"><svg fill="none" stroke="#D97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg></div>
            <div><div class="qa-label">Pengajuan Warga</div><div class="qa-sub">Verifikasi permohonan</div></div>
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="qa-card">
            <div class="qa-icon" style="background:#F5F3FF;"><svg fill="none" stroke="#7C3AED" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
            <div><div class="qa-label">Laporan</div><div class="qa-sub">Statistik pelayanan</div></div>
        </a>
    </div>

</x-app-layout>
