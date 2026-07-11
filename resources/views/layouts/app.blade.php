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
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; background: #F0F4F8; }

        /* ── Sidebar ──────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 260px;
            background: #0B1F3A;
            display: flex; flex-direction: column;
            z-index: 100; overflow: hidden;
        }
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

        .sidebar-section { padding: 16px 12px 4px; }
        .sidebar-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
            color: rgba(255,255,255,0.3); text-transform: uppercase; padding: 0 8px 8px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px; margin-bottom: 2px;
            color: rgba(255,255,255,0.6); font-size: 13.5px; font-weight: 500;
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
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
    </div>

    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'validator')
    <div class="sidebar-section">
        <div class="sidebar-section-label">Administrasi</div>
        <a href="{{ route('admin.warga.index') }}" class="nav-item {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Data Warga
        </a>
        <a href="{{ route('admin.surat.index') }}" class="nav-item {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Surat Administrasi
        </a>
        <a href="{{ route('admin.pengajuan-surat.index') }}" class="nav-item {{ request()->routeIs('admin.pengajuan-surat.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            Pengajuan Warga
        </a>
        <a href="{{ route('admin.jenis-surat.index') }}" class="nav-item {{ request()->routeIs('admin.jenis-surat.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Jenis Surat
        </a>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">Data & Laporan</div>
        <a href="{{ route('admin.blt.index') }}" class="nav-item {{ request()->routeIs('admin.blt.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Data Bantuan
        </a>
        <a href="{{ route('admin.arsip.index') }}" class="nav-item {{ request()->routeIs('admin.arsip.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            Arsip Digital
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Laporan
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
</body>
</html>
