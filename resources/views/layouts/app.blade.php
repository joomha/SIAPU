<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIAPU') }} &mdash; Desa Kadubeureum</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; background: #F0F4F8; }

        /* ── Sidebar ──────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 260px;
            background: #0B1F3A;
            display: flex; flex-direction: column;
            z-index: 100; overflow-y: auto; overflow-x: hidden;
        }
        
        /* Custom Scrollbar for Sidebar */
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        
        .sidebar-brand {
            display: flex; align-items: center; gap: 12px;
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-logo {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 18px; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(59,130,246,0.4);
        }
        .sidebar-brand-text { line-height: 1.1; }
        .sidebar-brand-text strong { display: block; color: #fff; font-size: 14px; font-weight: 700; letter-spacing: 0.3px; }
        .sidebar-brand-text span { color: rgba(255,255,255,0.45); font-size: 11px; font-weight: 500; }

        .sidebar-section { padding: 10px 12px 2px; }
        .sidebar-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
            color: rgba(255,255,255,0.3); text-transform: uppercase; padding: 0 8px 6px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 12px; border-radius: 8px; margin-bottom: 1px;
            color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.15s ease;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .nav-item.active {
            background: rgba(59,130,246,0.18); color: #60A5FA; font-weight: 600;
            border-left: 3px solid #3B82F6; padding-left: 9px;
        }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; opacity: 0.8; }
        .nav-item.active svg { opacity: 1; }

        .sidebar-footer {
            margin-top: auto; padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .user-card {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px; background: rgba(255,255,255,0.05);
        }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #6366F1, #4F46E5);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: 13px; flex-shrink: 0;
        }
        .user-info strong { display: block; color: #fff; font-size: 13px; font-weight: 600; }
        .user-info span { color: rgba(255,255,255,0.4); font-size: 11px; }
        .logout-btn {
            margin-left: auto; background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,0.35); padding: 4px;
            transition: color 0.15s; border-radius: 6px;
        }
        .logout-btn:hover { color: #F87171; }
        .logout-btn svg { width: 16px; height: 16px; }

        /* ── Main area ────────────────────────────── */
        .main-wrap { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: #fff; border-bottom: 1px solid #E2E8F0;
            padding: 0 28px; height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 16px; font-weight: 700; color: #0F172A; }
        .topbar-breadcrumb { font-size: 12px; color: #94A3B8; margin-top: 2px; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .topbar-badge {
            background: #EFF6FF; color: #1D4ED8; font-size: 11px; font-weight: 600;
            padding: 4px 10px; border-radius: 20px; border: 1px solid #BFDBFE;
        }
        .page-content { padding: 28px; flex: 1; }

        /* ── Cards & Tables ───────────────────────── */
        .card {
            background: #fff; border-radius: 14px; border: 1px solid #E2E8F0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .card-header {
            padding: 18px 22px; border-bottom: 1px solid #F1F5F9;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 { font-size: 14px; font-weight: 700; color: #0F172A; margin: 0; }
        .card-body { padding: 20px 22px; }

        .stat-card {
            background: #fff; border-radius: 14px; border: 1px solid #E2E8F0;
            padding: 20px 22px; display: flex; align-items: flex-start; gap: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .stat-icon {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .stat-icon svg { width: 22px; height: 22px; }
        .stat-value { font-size: 28px; font-weight: 800; color: #0F172A; line-height: 1; }
        .stat-label { font-size: 12px; color: #64748B; font-weight: 500; margin-top: 4px; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            text-align: left; padding: 10px 14px;
            font-size: 11px; font-weight: 700; color: #94A3B8;
            text-transform: uppercase; letter-spacing: 0.6px;
            background: #F8FAFC; border-bottom: 1px solid #E2E8F0;
        }
        .data-table td {
            padding: 13px 14px; font-size: 13.5px; color: #334155;
            border-bottom: 1px solid #F1F5F9;
        }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: #F8FAFC; }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600;
        }
        .badge-yellow { background: #FEF9C3; color: #A16207; }
        .badge-blue   { background: #DBEAFE; color: #1E40AF; }
        .badge-green  { background: #DCFCE7; color: #166534; }
        .badge-red    { background: #FEE2E2; color: #991B1B; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all 0.15s; }
        .btn-primary { background: #2563EB; color: #fff; }
        .btn-primary:hover { background: #1D4ED8; }
        .btn-ghost { background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0; }
        .btn-ghost:hover { background: #E2E8F0; }
        .btn-danger { background: #FEE2E2; color: #991B1B; }
        .btn-danger:hover { background: #FECACA; }
        .btn svg { width: 15px; height: 15px; }

        /* Inputs */
        .form-input {
            border: 1px solid #CBD5E1; border-radius: 8px; padding: 8px 12px;
            font-size: 13.5px; color: #0F172A; background: #fff; width: 100%;
            font-family: inherit; outline: none; transition: border-color 0.15s;
        }
        .form-input:focus { border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 5px; }

        .alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; padding: 12px 16px; border-radius: 10px; font-size: 13.5px; margin-bottom: 16px; }
        .alert-error   { background: #FFF7ED; border: 1px solid #FED7AA; color: #9A3412; padding: 12px 16px; border-radius: 10px; font-size: 13.5px; margin-bottom: 16px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">K</div>
        <div class="sidebar-brand-text">
            <strong>SIAPU</strong>
            <span>Desa Kadubeureum</span>
        </div>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">Menu Utama</div>
        @php
            $dashboardRoute = 'dashboard';
            if(auth()->user()->role === 'validator') $dashboardRoute = 'kades.dashboard';
            if(auth()->user()->role === 'warga') $dashboardRoute = 'warga.dashboard';
        @endphp
        <a href="{{ route($dashboardRoute) }}" class="nav-item {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="sidebar-section">
        <div class="sidebar-section-label">Master Data</div>
        <a href="{{ route('admin.warga.index') }}" class="nav-item {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Data Warga
        </a>
        <a href="{{ route('admin.jenis-surat.index') }}" class="nav-item {{ request()->routeIs('admin.jenis-surat.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Jenis Surat
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">Pelayanan</div>
        <a href="{{ route('admin.pengajuan-surat.index') }}" class="nav-item {{ request()->routeIs('admin.pengajuan-surat.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Pengajuan Warga
        </a>
        <a href="{{ route('admin.surat.index') }}" class="nav-item {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Surat Administrasi
        </a>
        <a href="{{ route('admin.arsip.index') }}" class="nav-item {{ request()->routeIs('admin.arsip.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            Arsip Digital
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">Laporan & Statistik</div>
        <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Laporan
        </a>
        <a href="{{ route('admin.activity_log.index') }}" class="nav-item {{ request()->routeIs('admin.activity_log.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Audit Trail
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">Pemeliharaan</div>
        <a href="{{ route('admin.backup.index') }}" class="nav-item {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <span>Backup Database</span>
        </a>
    </div>

    <!-- Konfigurasi Section -->
    <div class="sidebar-section">
        <div class="sidebar-section-label">Konfigurasi</div>
        <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Pengaturan Sistem
        </a>
    </div>
    @elseif(auth()->user()->role === 'warga')
    <div class="sidebar-section">
        <div class="sidebar-section-label">Layanan Warga</div>
        <a href="{{ route('warga.profil') }}" class="nav-item {{ request()->routeIs('warga.profil') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profil & Dokumen
        </a>
    </div>
    @endif

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <strong>{{ Auth::user()->name }}</strong>
                <span>{{ ucfirst(Auth::user()->role ?? 'Admin') }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-left:auto">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="main-wrap">
    <div class="topbar">
        <div>
            @isset($header)
                <div class="topbar-title">{{ $header }}</div>
            @else
                <div class="topbar-title">Dashboard</div>
            @endisset
        </div>
        <div class="topbar-right">
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'validator']))
            <button onclick="showNotifPopup()" style="background:transparent; border:none; position:relative; margin-right: 15px; color: #64748B; display: flex; align-items: center; cursor:pointer;" title="Notifikasi Pengajuan">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:22px;height:22px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                <span id="notif-badge" style="position:absolute; top:-6px; right:-8px; background: #EF4444; color:white; font-size:10px; font-weight:bold; padding:1px 5px; border-radius:10px; display:none;">0</span>
            </button>
            @endif
            <span class="topbar-badge">{{ date('d M Y') }}</span>
            <a href="{{ route('home') }}" class="btn btn-ghost" style="padding: 6px 12px; font-size: 12px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Halaman Publik
            </a>
        </div>
    </div>

    <main class="page-content">
        {{ $slot }}
    </main>
</div>

<!-- ═══ POPUP "NIAT" DESA KADUBEUREUM ═══ -->
<style>
    .desa-popup-overlay {
        position: fixed; inset: 0; z-index: 99999;
        background: rgba(11, 31, 58, 0.6); backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden;
        transition: opacity 0.35s ease, visibility 0.35s ease;
    }
    .desa-popup-overlay.active { opacity: 1; visibility: visible; }

    .desa-popup {
        background: #fff; border-radius: 20px; padding: 0;
        width: 420px; max-width: 92vw;
        box-shadow: 0 25px 60px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.1);
        transform: scale(0.85) translateY(20px);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
    }
    .desa-popup-overlay.active .desa-popup { transform: scale(1) translateY(0); }

    .desa-popup-header {
        display: flex; align-items: center; gap: 12px;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #F1F5F9;
    }
    .desa-popup-logo {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, #3B82F6, #1D4ED8);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #fff; font-size: 16px; flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(59,130,246,0.35);
    }
    .desa-popup-brand strong { display: block; font-size: 14px; font-weight: 700; color: #0B1F3A; }
    .desa-popup-brand span { font-size: 11px; color: #94A3B8; font-weight: 500; }

    .desa-popup-body { padding: 28px 24px; text-align: center; }

    .desa-popup-icon {
        width: 72px; height: 72px; border-radius: 50%; margin: 0 auto 18px;
        display: flex; align-items: center; justify-content: center;
        transform: scale(0); transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.15s;
    }
    .desa-popup-overlay.active .desa-popup-icon { transform: scale(1); }
    .desa-popup-icon svg { width: 36px; height: 36px; }

    .desa-popup-icon.success { background: #DCFCE7; }
    .desa-popup-icon.success svg { stroke: #16A34A; }
    .desa-popup-icon.error { background: #FEE2E2; }
    .desa-popup-icon.error svg { stroke: #DC2626; }
    .desa-popup-icon.confirm { background: #DBEAFE; }
    .desa-popup-icon.confirm svg { stroke: #2563EB; }
    .desa-popup-icon.warning { background: #FEF9C3; }
    .desa-popup-icon.warning svg { stroke: #D97706; }

    .desa-popup-title {
        font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        font-size: 18px; font-weight: 700; color: #0F172A; margin-bottom: 8px;
    }
    .desa-popup-message {
        font-size: 14px; color: #64748B; line-height: 1.6; margin-bottom: 0;
    }

    .desa-popup-footer {
        padding: 0 24px 24px; display: flex; gap: 10px; justify-content: center;
    }
    .desa-popup-btn {
        padding: 10px 28px; border-radius: 10px; font-size: 14px; font-weight: 600;
        border: none; cursor: pointer; transition: all 0.2s ease;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .desa-popup-btn.primary { background: #2563EB; color: #fff; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
    .desa-popup-btn.primary:hover { background: #1D4ED8; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(37,99,235,0.4); }
    .desa-popup-btn.danger { background: #DC2626; color: #fff; box-shadow: 0 4px 12px rgba(220,38,38,0.3); }
    .desa-popup-btn.danger:hover { background: #B91C1C; transform: translateY(-1px); }
    .desa-popup-btn.ghost { background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0; }
    .desa-popup-btn.ghost:hover { background: #E2E8F0; }
    .desa-popup-btn.success-btn { background: #16A34A; color: #fff; box-shadow: 0 4px 12px rgba(22,163,74,0.3); }
    .desa-popup-btn.success-btn:hover { background: #15803D; transform: translateY(-1px); }

    /* Progress bar for auto-dismiss */
    .desa-popup-progress {
        height: 3px; background: #E2E8F0; border-radius: 0 0 20px 20px; overflow: hidden;
    }
    .desa-popup-progress-bar {
        height: 100%; border-radius: 0 0 20px 20px;
        transition: width linear;
    }
    .desa-popup-progress-bar.success { background: #16A34A; }
    .desa-popup-progress-bar.error { background: #DC2626; }
</style>

<!-- Popup Container -->
<div class="desa-popup-overlay" id="desaPopupOverlay">
    <div class="desa-popup">
        <div class="desa-popup-header">
            <div class="desa-popup-logo">K</div>
            <div class="desa-popup-brand">
                <strong>SIAPU</strong>
                <span>Desa Kadubeureum</span>
            </div>
        </div>
        <div class="desa-popup-body">
            <div class="desa-popup-icon" id="desaPopupIcon">
                <svg id="desaPopupSvg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></svg>
            </div>
            <div class="desa-popup-title" id="desaPopupTitle"></div>
            <div class="desa-popup-message" id="desaPopupMessage"></div>
        </div>
        <div class="desa-popup-footer" id="desaPopupFooter"></div>
        <div class="desa-popup-progress" id="desaPopupProgress" style="display:none;">
            <div class="desa-popup-progress-bar" id="desaPopupProgressBar" style="width:100%;"></div>
        </div>
    </div>
</div>

<script>
    const DesaPopup = {
        overlay: null,
        autoTimer: null,

        init() {
            this.overlay = document.getElementById('desaPopupOverlay');
            // Close on overlay click (not popup body)
            this.overlay?.addEventListener('click', (e) => {
                if (e.target === this.overlay) this.close();
            });
        },

        show({ type = 'success', title = '', message = '', autoDismiss = 0, buttons = null }) {
            const icon = document.getElementById('desaPopupIcon');
            const svg = document.getElementById('desaPopupSvg');
            const titleEl = document.getElementById('desaPopupTitle');
            const msgEl = document.getElementById('desaPopupMessage');
            const footer = document.getElementById('desaPopupFooter');
            const progress = document.getElementById('desaPopupProgress');
            const progressBar = document.getElementById('desaPopupProgressBar');

            // Set icon
            icon.className = 'desa-popup-icon ' + type;
            const paths = {
                success: '<path d="M5 13l4 4L19 7"/>',
                error: '<path d="M6 18L18 6M6 6l12 12"/>',
                confirm: '<path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01"/>',
                warning: '<path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>'
            };
            svg.innerHTML = paths[type] || paths.success;

            titleEl.textContent = title;
            msgEl.textContent = message;

            // Buttons
            footer.innerHTML = '';
            if (buttons) {
                buttons.forEach(btn => {
                    const el = document.createElement('button');
                    el.className = 'desa-popup-btn ' + (btn.class || 'primary');
                    el.textContent = btn.label;
                    el.addEventListener('click', () => {
                        this.close();
                        if (btn.action) btn.action();
                    });
                    footer.appendChild(el);
                });
            } else {
                const okBtn = document.createElement('button');
                okBtn.className = 'desa-popup-btn ' + (type === 'success' ? 'success-btn' : (type === 'error' ? 'danger' : 'primary'));
                okBtn.textContent = 'Mengerti';
                okBtn.addEventListener('click', () => this.close());
                footer.appendChild(okBtn);
            }

            // Auto dismiss
            if (this.autoTimer) clearTimeout(this.autoTimer);
            if (autoDismiss > 0) {
                progress.style.display = 'block';
                progressBar.className = 'desa-popup-progress-bar ' + type;
                progressBar.style.transition = 'none';
                progressBar.style.width = '100%';
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        progressBar.style.transition = `width ${autoDismiss}ms linear`;
                        progressBar.style.width = '0%';
                    });
                });
                this.autoTimer = setTimeout(() => this.close(), autoDismiss);
            } else {
                progress.style.display = 'none';
            }

            this.overlay.classList.add('active');
        },

        close() {
            if (this.autoTimer) clearTimeout(this.autoTimer);
            this.overlay?.classList.remove('active');
        }
    };

    // Global confirm replacement
    function desaConfirm(message, onConfirm, title) {
        DesaPopup.show({
            type: 'confirm',
            title: title || 'Konfirmasi Tindakan',
            message: message,
            buttons: [
                { label: 'Batal', class: 'ghost', action: null },
                { label: 'Ya, Lanjutkan', class: 'primary', action: onConfirm }
            ]
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        DesaPopup.init();

        // Auto-show for session flashes
        @if(session('success'))
            DesaPopup.show({
                type: 'success',
                title: 'Berhasil!',
                message: @json(session('success')),
                autoDismiss: 5000
            });
        @endif

        @if(session('error'))
            DesaPopup.show({
                type: 'error',
                title: 'Terjadi Kesalahan',
                message: @json(session('error'))
            });
        @endif
    });
</script>
<!-- ═══ END POPUP "NIAT" ═══ -->

<!-- CUSTOM CURSOR -->
<style>
    body { cursor: none; }
    .cursor-dot { width: 8px; height: 8px; background: #2563EB; border-radius: 50%; position: fixed; pointer-events: none; z-index: 999999; transform: translate(-50%, -50%); transition: width 0.2s, height 0.2s; }
    .cursor-outline { width: 40px; height: 40px; border: 2px solid rgba(37,99,235,0.5); border-radius: 50%; position: fixed; pointer-events: none; z-index: 999998; transform: translate(-50%, -50%); transition: transform 0.15s ease-out, width 0.2s, height 0.2s, background 0.2s; }
    body:hover .cursor-dot, body:hover .cursor-outline { opacity: 1; }
    a:hover ~ .cursor-outline, button:hover ~ .cursor-outline, input:hover ~ .cursor-outline, select:hover ~ .cursor-outline, textarea:hover ~ .cursor-outline, .btn:hover ~ .cursor-outline { transform: translate(-50%, -50%) scale(1.5); background: rgba(37,99,235,0.1); border-color: transparent; }
    a, button, input, select, textarea, .btn, .nav-link, .nav-brand { cursor: none !important; }
    @media (max-width: 768px) { .cursor-dot, .cursor-outline { display: none !important; } body { cursor: auto; } a, button, input, select, textarea { cursor: pointer !important; } }
</style>

<div class="cursor-dot" id="cursorDotGlobal"></div>
<div class="cursor-outline" id="cursorOutlineGlobal"></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dot = document.getElementById('cursorDotGlobal');
        const outline = document.getElementById('cursorOutlineGlobal');
        
        if (dot && outline) {
            window.addEventListener('mousemove', function(e) {
                dot.style.left = e.clientX + 'px';
                dot.style.top = e.clientY + 'px';
                setTimeout(() => {
                    outline.style.left = e.clientX + 'px';
                    outline.style.top = e.clientY + 'px';
                }, 50);
            });
            
            const attachEvents = () => {
                document.querySelectorAll('a, button, input, select, textarea, .btn, .nav-link, .nav-brand').forEach(el => {
                    if (!el.dataset.cursorAttached) {
                        el.addEventListener('mouseenter', () => {
                            outline.style.transform = 'translate(-50%, -50%) scale(1.5)';
                            outline.style.background = 'rgba(37,99,235,0.1)';
                            outline.style.borderColor = 'transparent';
                        });
                        el.addEventListener('mouseleave', () => {
                            outline.style.transform = 'translate(-50%, -50%) scale(1)';
                            outline.style.background = 'transparent';
                            outline.style.borderColor = 'rgba(37,99,235,0.5)';
                        });
                        el.dataset.cursorAttached = 'true';
                    }
                });
            };
            
            attachEvents();
            // Optional: re-attach on DOM mutations if needed
            const observer = new MutationObserver(attachEvents);
            observer.observe(document.body, { childList: true, subtree: true });
        }
    });
</script>
<!-- END CUSTOM CURSOR -->
@stack('scripts')
@if(auth()->check() && in_array(auth()->user()->role, ['admin', 'validator']))
<script>
    function showNotifPopup() {
        let count = parseInt(document.getElementById('notif-badge').innerText || '0');
        if(count > 0) {
            let route = '{{ auth()->user()->role === "admin" ? route("admin.pengajuan-surat.index") : route("kades.dashboard") }}';
            DesaPopup.show({
                type: 'confirm',
                title: 'Notifikasi',
                message: 'Terdapat ' + count + ' pengajuan baru yang menunggu diproses.',
                buttons: [
                    { label: 'Tutup', class: 'ghost', action: null },
                    { label: 'Lihat Pengajuan', class: 'primary', action: () => window.location.href = route }
                ]
            });
        } else {
            DesaPopup.show({
                type: 'success',
                title: 'Tidak Ada Notifikasi',
                message: 'Saat ini tidak ada pengajuan baru yang menunggu.',
                autoDismiss: 3000
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        function fetchNotifCount() {
            fetch('{{ route('api.notif-count') }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notif-badge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(error => console.error('Error fetching notif:', error));
        }
        fetchNotifCount();
        setInterval(fetchNotifCount, 15000);
    });
</script>
@endif
</body>
</html>
