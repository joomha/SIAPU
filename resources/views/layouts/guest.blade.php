<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIAPU') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; }

        .auth-left {
            width: 480px; flex-shrink: 0;
            background: #0B1F3A;
            display: flex; flex-direction: column;
            padding: 48px 48px;
            position: relative; overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute; top: -80px; right: -80px;
            width: 320px; height: 320px; border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, transparent 70%);
        }
        .auth-left::after {
            content: '';
            position: absolute; bottom: -60px; left: -60px;
            width: 260px; height: 260px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
        }
        .auth-brand {
            display: flex; align-items: center; gap: 14px; position: relative; z-index: 1;
        }
        .auth-logo {
            width: 48px; height: 48px; border-radius: 12px;
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 22px;
            box-shadow: 0 6px 20px rgba(59,130,246,0.4);
        }
        .auth-brand-name { color: #fff; font-weight: 800; font-size: 18px; letter-spacing: -0.3px; }
        .auth-brand-sub { color: rgba(255,255,255,0.45); font-size: 12px; }

        .auth-hero { flex: 1; display: flex; flex-direction: column; justify-content: center; position: relative; z-index: 1; }
        .auth-hero h1 {
            color: #fff; font-size: 34px; font-weight: 800; line-height: 1.15;
            margin-bottom: 16px; letter-spacing: -0.5px;
        }
        .auth-hero h1 em { font-style: normal; color: #60A5FA; }
        .auth-hero p { color: rgba(255,255,255,0.55); font-size: 14px; line-height: 1.7; max-width: 340px; }

        .auth-stats {
            display: flex; gap: 20px; margin-top: 40px; position: relative; z-index: 1;
        }
        .auth-stat {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 14px 18px;
        }
        .auth-stat strong { display: block; color: #fff; font-size: 22px; font-weight: 800; }
        .auth-stat span { color: rgba(255,255,255,0.45); font-size: 11px; }

        .auth-footer-text {
            color: rgba(255,255,255,0.25); font-size: 11px;
            position: relative; z-index: 1; margin-top: 40px;
        }

        /* Right panel */
        .auth-right {
            flex: 1; display: flex; align-items: center; justify-content: center;
            background: #F0F4F8; padding: 40px;
        }
        .auth-form-card {
            background: #fff; border-radius: 20px;
            padding: 40px 44px; width: 100%; max-width: 420px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .auth-form-card h2 { font-size: 22px; font-weight: 800; color: #0F172A; margin-bottom: 6px; }
        .auth-form-card > p { color: #64748B; font-size: 13.5px; margin-bottom: 28px; }
    </style>
</head>
<body>

<div class="auth-left">
    <div class="auth-brand">
        <div class="auth-logo">K</div>
        <div>
            <div class="auth-brand-name">SIAPU</div>
            <div class="auth-brand-sub">Kelurahan Kadubeureum</div>
        </div>
    </div>

    <div class="auth-hero">
        <h1>Sistem Administrasi <em>Modern</em> untuk Warga</h1>
        <p>Pengelolaan data warga, penerbitan surat, dan transparansi BLT dalam satu platform terintegrasi.</p>

        <div class="auth-stats">
            <div class="auth-stat">
                <strong>100%</strong>
                <span>Digital</span>
            </div>
            <div class="auth-stat">
                <strong>Cepat</strong>
                <span>Pelayanan</span>
            </div>
            <div class="auth-stat">
                <strong>Aman</strong>
                <span>Terenkripsi</span>
            </div>
        </div>
    </div>

    <div class="auth-footer-text">
        &copy; {{ date('Y') }} Desa Kadubeureum, Kec. Pabuaran, Kab. Serang
    </div>
</div>

<div class="auth-right">
    <div class="auth-form-card">
        {{ $slot }}
    </div>
</div>

</body>
</html>
