<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAPU — Desa Kadubeureum</title>
    <meta name="description" content="Sistem Informasi Administrasi Pelayanan Umum Desa Kadubeureum, Kecamatan Pabuaran, Kabupaten Serang.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #FAFAFA; color: #1A1A2E; overflow-x: hidden; }
        img { max-width: 100%; height: auto; display: block; }

        /* ── ANIMATIONS ────────────────────────────── */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInRight { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.85); } to { opacity: 1; transform: scale(1); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 0 0 rgba(37,99,235,0.4); } 50% { box-shadow: 0 0 0 12px rgba(37,99,235,0); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-50px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(50px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }
        .reveal-scale { opacity: 0; transform: scale(0.85); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .reveal-scale.visible { opacity: 1; transform: scale(1); }
        .delay-1 { transition-delay: 0.1s; } .delay-2 { transition-delay: 0.2s; } .delay-3 { transition-delay: 0.3s; } .delay-4 { transition-delay: 0.4s; } .delay-5 { transition-delay: 0.5s; }

        /* ── NAV ─────────────────────────────────── */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 0 40px; height: 68px; display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.88); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(0,0,0,0.07); transition: all 0.3s ease; }
        .navbar.scrolled { box-shadow: 0 4px 30px rgba(0,0,0,0.08); height: 60px; }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .nav-logo { width: 38px; height: 38px; border-radius: 9px; background: #0B1F3A; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #fff; font-size: 16px; transition: transform 0.3s ease; }
        .nav-brand:hover .nav-logo { transform: rotate(-8deg) scale(1.08); }
        .nav-name { font-weight: 800; font-size: 16px; color: #0B1F3A; letter-spacing: -0.3px; }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-links a { color: #475569; font-size: 14px; font-weight: 500; text-decoration: none; transition: color 0.2s; position: relative; }
        .nav-links a::after { content: ''; position: absolute; bottom: -4px; left: 0; right: 0; height: 2px; background: #2563EB; border-radius: 2px; transform: scaleX(0); transition: transform 0.3s ease; transform-origin: center; }
        .nav-links a:hover { color: #0B1F3A; }
        .nav-links a:hover::after { transform: scaleX(1); }
        .nav-cta { background: #0B1F3A; color: #fff !important; padding: 9px 20px; border-radius: 8px; font-weight: 700; font-size: 13.5px; text-decoration: none; transition: all 0.3s; }
        .nav-cta::after { display: none !important; }
        .nav-cta:hover { background: #1E3A5F; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(11,31,58,0.25); }

        /* ── HERO ────────────────────────────────── */
        .hero { min-height: 100vh; background: #0B1F3A; display: flex; align-items: center; padding: 120px 40px 80px; position: relative; overflow: hidden; }
        .hero-bg-image { position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1590005354167-6da97ce231ce?w=1920&q=80') center/cover no-repeat; opacity: 0.1; pointer-events: none; }
        .hero-glow-1 { position: absolute; top: -100px; right: 5%; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.25) 0%, transparent 65%); pointer-events: none; animation: float 8s ease-in-out infinite; }
        .hero-glow-2 { position: absolute; bottom: -80px; left: 10%; width: 380px; height: 380px; border-radius: 50%; background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 65%); pointer-events: none; animation: float 6s ease-in-out infinite reverse; }
        .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; max-width: 1200px; margin: 0 auto; align-items: center; position: relative; z-index: 1; }
        .hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.3); padding: 5px 14px; border-radius: 20px; color: #93C5FD; font-size: 12px; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 20px; animation: fadeInUp 0.6s ease forwards; }
        .hero-eyebrow::before { content: '●'; font-size: 8px; color: #60A5FA; }
        .hero h1 { color: #fff; font-size: 52px; font-weight: 900; line-height: 1.1; letter-spacing: -1.5px; margin-bottom: 22px; animation: fadeInUp 0.7s ease 0.1s forwards; opacity: 0; }
        .hero h1 .accent { background: linear-gradient(90deg, #60A5FA, #A78BFA, #60A5FA); background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; animation: shimmer 4s linear infinite; }
        .hero p { color: rgba(255,255,255,0.55); font-size: 17px; line-height: 1.7; margin-bottom: 36px; max-width: 480px; animation: fadeInUp 0.7s ease 0.2s forwards; opacity: 0; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; animation: fadeInUp 0.7s ease 0.3s forwards; opacity: 0; }
        .btn-hero-primary { background: #2563EB; color: #fff; padding: 13px 26px; border-radius: 10px; font-weight: 700; font-size: 15px; text-decoration: none; box-shadow: 0 0 0 3px rgba(37,99,235,0.3); transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; position: relative; overflow: hidden; }
        .btn-hero-primary::before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transform: translateX(-100%); transition: transform 0.6s; }
        .btn-hero-primary:hover::before { transform: translateX(100%); }
        .btn-hero-primary:hover { background: #1D4ED8; box-shadow: 0 0 0 5px rgba(37,99,235,0.25); transform: translateY(-3px); }
        .btn-hero-ghost { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.85); padding: 13px 26px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15); font-weight: 600; font-size: 15px; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-hero-ghost:hover { background: rgba(255,255,255,0.14); color: #fff; transform: translateY(-3px); border-color: rgba(255,255,255,0.3); }
        .hero-panel { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 28px; backdrop-filter: blur(10px); animation: scaleIn 0.8s ease 0.4s forwards; opacity: 0; }
        .hero-panel-title { color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 20px; }
        .panel-item { display: flex; align-items: center; gap: 14px; padding: 14px 16px; border-radius: 12px; background: rgba(255,255,255,0.04); margin-bottom: 10px; border: 1px solid rgba(255,255,255,0.06); transition: all 0.3s; cursor: default; }
        .panel-item:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); transform: translateX(6px); }
        .panel-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: transform 0.3s; }
        .panel-item:hover .panel-icon { transform: scale(1.1) rotate(-5deg); }
        .panel-icon svg { width: 18px; height: 18px; }
        .panel-label { color: rgba(255,255,255,0.7); font-size: 13px; font-weight: 600; }
        .panel-sub { color: rgba(255,255,255,0.3); font-size: 11px; }
        .panel-check { margin-left: auto; }
        .panel-check svg { width: 18px; height: 18px; color: #34D399; }
        .hero-stat-row { display: flex; gap: 10px; margin-top: 16px; }
        .hero-stat { flex: 1; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 14px; transition: all 0.3s; cursor: default; }
        .hero-stat:hover { background: rgba(255,255,255,0.08); transform: translateY(-3px); }
        .hero-stat strong { display: block; color: #fff; font-size: 20px; font-weight: 800; }
        .hero-stat span { color: rgba(255,255,255,0.35); font-size: 11px; }

        /* ── TICKER ─────────────────────────────── */
        .ticker { background: #1E3A5F; padding: 10px 0; overflow: hidden; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .ticker-track { display: flex; gap: 48px; width: max-content; animation: marquee 35s linear infinite; }
        .ticker-item { display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 500; white-space: nowrap; }
        .ticker-dot { width: 6px; height: 6px; border-radius: 50%; background: #34D399; flex-shrink: 0; }
        .ticker-dot.yellow { background: #FBBF24; }

        /* ── SECTION COMMONS ─────────────────────── */
        .section-header { text-align: center; max-width: 560px; margin: 0 auto 60px; }
        .section-label { display: inline-block; font-size: 11.5px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #2563EB; margin-bottom: 12px; }
        .section-title { font-size: 36px; font-weight: 900; color: #0B1F3A; letter-spacing: -0.8px; margin-bottom: 14px; line-height: 1.15; }
        .section-desc { color: #64748B; font-size: 15px; line-height: 1.7; }

        /* ── ABOUT ─────────────────────────────── */
        .about { padding: 100px 40px; background: #fff; }
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; max-width: 1200px; margin: 0 auto; align-items: center; }
        .about-images { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; position: relative; }
        .about-img { border-radius: 16px; overflow: hidden; position: relative; transition: all 0.4s ease; }
        .about-img img { width: 100%; height: 200px; object-fit: cover; transition: transform 0.6s ease; }
        .about-img:hover img { transform: scale(1.08); }
        .about-img:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.15); }
        .about-img:first-child { grid-row: span 2; }
        .about-img:first-child img { height: 100%; min-height: 412px; }
        .about-badge { position: absolute; bottom: -20px; right: -20px; background: #2563EB; color: #fff; padding: 18px 22px; border-radius: 16px; font-weight: 800; font-size: 13px; box-shadow: 0 10px 30px rgba(37,99,235,0.3); z-index: 2; animation: float 4s ease-in-out infinite; }
        .about-badge strong { display: block; font-size: 28px; line-height: 1; margin-bottom: 2px; }
        .about-content .section-label, .about-content .section-title { text-align: left; }
        .about-content p { color: #64748B; font-size: 15px; line-height: 1.8; margin-bottom: 16px; }
        .about-features { display: flex; flex-direction: column; gap: 12px; margin-top: 20px; }
        .about-feat { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; transition: all 0.3s; }
        .about-feat:hover { transform: translateX(8px); border-color: #BFDBFE; background: #EFF6FF; }
        .about-feat-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .about-feat-icon svg { width: 18px; height: 18px; }
        .about-feat span { font-size: 14px; font-weight: 600; color: #0F172A; }

        /* ── STATS ─────────────────────────────── */
        .stats { padding: 60px 40px; background: #fff; border-top: 1px solid #F1F5F9; border-bottom: 1px solid #F1F5F9; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; max-width: 1000px; margin: 0 auto; text-align: center; }
        .stat-item { padding: 20px; }
        .stat-number { font-size: 42px; font-weight: 900; color: #0B1F3A; letter-spacing: -1px; line-height: 1; }
        .stat-number .stat-suffix { font-size: 28px; color: #2563EB; }
        .stat-label { color: #64748B; font-size: 14px; font-weight: 500; margin-top: 6px; }

        /* ── SERVICES ─────────────────────────────── */
        .services { padding: 100px 40px; background: #F8FAFC; }
        .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; max-width: 1200px; margin: 0 auto; }
        .service-card { border: 1.5px solid #E2E8F0; border-radius: 18px; padding: 30px; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); background: #fff; position: relative; overflow: hidden; }
        .service-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #2563EB, #7C3AED); transform: scaleX(0); transition: transform 0.4s; transform-origin: left; }
        .service-card:hover::before { transform: scaleX(1); }
        .service-card:hover { border-color: #BFDBFE; box-shadow: 0 16px 48px rgba(37,99,235,0.1); transform: translateY(-8px); }
        .service-num { font-size: 11px; font-weight: 700; color: #CBD5E1; letter-spacing: 1px; margin-bottom: 16px; }
        .service-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; transition: transform 0.4s; }
        .service-card:hover .service-icon { transform: scale(1.15) rotate(-5deg); }
        .service-icon svg { width: 24px; height: 24px; }
        .service-title { font-size: 17px; font-weight: 800; color: #0F172A; margin-bottom: 10px; }
        .service-desc { color: #64748B; font-size: 14px; line-height: 1.65; margin-bottom: 20px; }
        .service-link { color: #2563EB; font-size: 13.5px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: gap 0.3s; }
        .service-link:hover { gap: 10px; }

        /* ── HOW ─────────────────────────────── */
        .how { padding: 100px 40px; background: #fff; }
        .steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; max-width: 1100px; margin: 0 auto; }
        .step { text-align: center; padding: 28px 20px; transition: all 0.3s; }
        .step:hover { transform: translateY(-6px); }
        .step-num { width: 56px; height: 56px; border-radius: 50%; background: #0B1F3A; color: #fff; font-size: 20px; font-weight: 900; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; transition: all 0.3s; }
        .step:hover .step-num { background: #2563EB; transform: scale(1.1); box-shadow: 0 8px 24px rgba(37,99,235,0.3); }
        .step h4 { font-size: 15px; font-weight: 700; color: #0F172A; margin-bottom: 8px; }
        .step p { color: #64748B; font-size: 13.5px; line-height: 1.6; }

        /* ── PERSYARATAN SURAT ──────────────────── */
        .persyaratan { padding: 100px 40px; background: #F8FAFC; }
        .persyaratan-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; }
        .persyaratan-card { background: #fff; border: 1.5px solid #E2E8F0; border-radius: 16px; overflow: hidden; transition: all 0.4s; }
        .persyaratan-card:hover { border-color: #BFDBFE; box-shadow: 0 12px 40px rgba(37,99,235,0.08); transform: translateY(-4px); }
        .persyaratan-header { padding: 20px 24px; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: background 0.2s; }
        .persyaratan-header:hover { background: #EFF6FF; }
        .persyaratan-icon { width: 40px; height: 40px; border-radius: 10px; background: #EFF6FF; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .persyaratan-icon svg { width: 18px; height: 18px; color: #2563EB; }
        .persyaratan-name { font-size: 15px; font-weight: 700; color: #0F172A; flex: 1; }
        .persyaratan-toggle { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; transition: transform 0.3s; color: #94A3B8; }
        .persyaratan-card.open .persyaratan-toggle { transform: rotate(180deg); }
        .persyaratan-body { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
        .persyaratan-card.open .persyaratan-body { max-height: 500px; }
        .persyaratan-list { padding: 20px 24px; }
        .persyaratan-list li { color: #475569; font-size: 14px; line-height: 1.6; padding: 4px 0; padding-left: 8px; border-left: 2px solid #DBEAFE; margin-bottom: 6px; margin-left: 4px; }

        /* ── ARTICLES ─────────────────────────────── */
        .articles { padding: 100px 40px; background: #fff; }
        .articles-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; max-width: 1200px; margin: 0 auto; }
        .article-card { background: #fff; border-radius: 18px; overflow: hidden; border: 1px solid #E2E8F0; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        .article-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(0,0,0,0.08); border-color: #BFDBFE; }
        .article-img { width: 100%; height: 200px; object-fit: cover; transition: transform 0.6s ease; }
        .article-card:hover .article-img { transform: scale(1.06); }
        .article-img-wrap { overflow: hidden; position: relative; }
        .article-tag { position: absolute; top: 14px; left: 14px; background: rgba(37,99,235,0.9); color: #fff; padding: 4px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; backdrop-filter: blur(6px); }
        .article-body { padding: 24px; }
        .article-date { color: #94A3B8; font-size: 12px; font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .article-date svg { width: 14px; height: 14px; }
        .article-title { font-size: 17px; font-weight: 800; color: #0F172A; margin-bottom: 10px; line-height: 1.4; transition: color 0.2s; }
        .article-card:hover .article-title { color: #2563EB; }
        .article-excerpt { color: #64748B; font-size: 14px; line-height: 1.65; margin-bottom: 16px; }
        .article-read { color: #2563EB; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: gap 0.3s; }
        .article-read:hover { gap: 8px; }

        /* ── EMERGENCY ─────────────────────────────── */
        .emergency { padding: 80px 40px; background: linear-gradient(135deg, #0B1F3A 0%, #1E3A5F 100%); position: relative; overflow: hidden; }
        .emergency::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); pointer-events: none; }
        .emergency-inner { max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }
        .emergency-header { text-align: center; margin-bottom: 50px; }
        .emergency-header h2 { color: #fff; font-size: 32px; font-weight: 900; margin-bottom: 10px; }
        .emergency-header p { color: rgba(255,255,255,0.5); font-size: 15px; }
        .emergency-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); padding: 5px 14px; border-radius: 20px; margin-bottom: 16px; color: #FCA5A5; font-size: 12px; font-weight: 700; letter-spacing: 0.5px; }
        .emergency-badge::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background: #EF4444; animation: pulse-glow 1.5s ease infinite; }
        .emergency-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
        .emergency-card { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 24px; text-align: center; transition: all 0.3s; cursor: default; }
        .emergency-card:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); transform: translateY(-6px); }
        .emergency-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; transition: transform 0.3s; }
        .emergency-card:hover .emergency-icon { transform: scale(1.15) rotate(-8deg); }
        .emergency-icon svg { width: 24px; height: 24px; }
        .emergency-name { color: #fff; font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .emergency-number { color: #60A5FA; font-size: 20px; font-weight: 900; letter-spacing: -0.5px; text-decoration: none; display: block; transition: color 0.2s; }
        .emergency-number:hover { color: #93C5FD; }
        .emergency-desc { color: rgba(255,255,255,0.35); font-size: 12px; margin-top: 4px; }

        /* ── GALLERY ─────────────────────────────── */
        .gallery { padding: 100px 40px; background: #F8FAFC; }
        .gallery-grid { display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(2, 220px); gap: 12px; max-width: 1200px; margin: 0 auto; }
        .gallery-item { border-radius: 16px; overflow: hidden; position: relative; cursor: pointer; transition: all 0.4s; }
        .gallery-item:hover { transform: scale(1.02); z-index: 2; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s; }
        .gallery-item:hover img { transform: scale(1.1); }
        .gallery-overlay { position: absolute; inset: 0; background: linear-gradient(180deg, transparent 40%, rgba(11,31,58,0.8) 100%); display: flex; align-items: flex-end; padding: 20px; opacity: 0; transition: opacity 0.3s; }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        .gallery-overlay span { color: #fff; font-size: 14px; font-weight: 700; }
        .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }

        /* ── CTA ─────────────────────────────── */
        .cta-banner { padding: 80px 40px; position: relative; overflow: hidden; background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%); }
        .cta-inner { max-width: 700px; margin: 0 auto; text-align: center; position: relative; z-index: 1; }
        .cta-inner h2 { color: #fff; font-size: 36px; font-weight: 900; margin-bottom: 16px; letter-spacing: -0.5px; }
        .cta-inner p { color: rgba(255,255,255,0.7); font-size: 17px; line-height: 1.7; margin-bottom: 32px; }
        .cta-buttons { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; }
        .btn-cta-white { background: #fff; color: #2563EB; padding: 14px 32px; border-radius: 12px; font-weight: 800; font-size: 15px; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
        .btn-cta-white:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0,0,0,0.2); }
        .btn-cta-outline { background: transparent; color: #fff; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 15px; text-decoration: none; border: 2px solid rgba(255,255,255,0.3); transition: all 0.3s; }
        .btn-cta-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.6); transform: translateY(-3px); }
        .cta-glow { position: absolute; width: 400px; height: 400px; border-radius: 50%; background: rgba(255,255,255,0.08); pointer-events: none; }
        .cta-glow-1 { top: -100px; right: -100px; }
        .cta-glow-2 { bottom: -150px; left: -100px; }

        /* ── FOOTER ───────────────────────────────── */
        footer { background: #0B1F3A; padding: 60px 40px 32px; }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .footer-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .footer-logo { width: 38px; height: 38px; border-radius: 9px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; font-weight: 900; color: #fff; font-size: 16px; }
        .footer-name { font-size: 16px; font-weight: 800; color: #fff; }
        .footer-about { color: rgba(255,255,255,0.35); font-size: 13px; max-width: 340px; line-height: 1.7; margin-bottom: 20px; }
        .footer-social { display: flex; gap: 10px; }
        .footer-social a { width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.5); text-decoration: none; transition: all 0.3s; }
        .footer-social a:hover { background: #2563EB; border-color: #2563EB; color: #fff; transform: translateY(-3px); }
        .footer-social a svg { width: 16px; height: 16px; }
        .footer-col h4 { color: #fff; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px; }
        .footer-col a { display: block; color: rgba(255,255,255,0.4); font-size: 14px; text-decoration: none; margin-bottom: 10px; transition: all 0.2s; }
        .footer-col a:hover { color: #60A5FA; transform: translateX(4px); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.08); padding-top: 24px; display: flex; justify-content: space-between; align-items: center; color: rgba(255,255,255,0.2); font-size: 12px; }

        /* ── SCROLL TOP ──────────────────────── */
        .scroll-top { position: fixed; bottom: 24px; right: 24px; z-index: 90; width: 44px; height: 44px; border-radius: 12px; background: #2563EB; color: #fff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(37,99,235,0.3); opacity: 0; transform: translateY(20px); transition: all 0.3s; pointer-events: none; }
        .scroll-top.show { opacity: 1; transform: translateY(0); pointer-events: all; }
        .scroll-top:hover { background: #1D4ED8; transform: translateY(-3px); }
        .scroll-top svg { width: 20px; height: 20px; }

        /* ── RESPONSIVE ──────────────────────────── */
        @media (max-width: 1024px) {
            .gallery-grid { grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(3, 180px); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .hero-grid { grid-template-columns: 1fr; } .hero-panel { display: none; } .hero h1 { font-size: 36px; }
            .navbar { padding: 0 20px; } .nav-links { display: none; }
            .about-grid { grid-template-columns: 1fr; }
            .about-images { grid-template-columns: 1fr 1fr; } .about-img:first-child { grid-row: span 1; } .about-img:first-child img { min-height: 200px; }
            .gallery-grid { grid-template-columns: 1fr 1fr; grid-template-rows: repeat(3, 160px); } .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 1; }
            .footer-grid { grid-template-columns: 1fr; } .footer-bottom { flex-direction: column; gap: 8px; text-align: center; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; } .stat-number { font-size: 32px; }
            .section-title { font-size: 28px; }
            .persyaratan-grid { grid-template-columns: 1fr; }
            .hero, .services, .how, .about, .articles, .emergency, .gallery, .cta-banner, .persyaratan { padding-left: 20px; padding-right: 20px; }
        }
    </style>
</head>
<body>

<nav class="navbar" id="mainNav">
    <a href="#" class="nav-brand"><div class="nav-logo">K</div><span class="nav-name">KADUBEUREUM</span></a>
    <div class="nav-links">
        <a href="#tentang">Tentang</a>
        <a href="#layanan">Layanan</a>
        <a href="#persyaratan">Persyaratan</a>
        <a href="#artikel">Artikel</a>
        <a href="#darurat">Darurat</a>
        <a href="{{ route('public.cek_status') }}">Cek Status</a>
        @auth <a href="{{ url('/dashboard') }}" class="nav-cta">Dashboard</a> @else <a href="{{ route('login') }}" class="nav-cta">Login Admin</a> @endauth
    </div>
</nav>

<!-- ══════════ HERO ══════════ -->
<section class="hero">
    <div class="hero-bg-image"></div>
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>
    <div class="hero-grid">
        <div>
            <div class="hero-eyebrow">SIAPU &mdash; Sistem Administrasi Digital</div>
            <h1>Layanan <span class="accent">Desa</span> dari Rumah Anda</h1>
            <p>Ajukan surat administrasi dan cek status permohonan &mdash; semua tanpa perlu datang ke kantor desa. Cepat, gratis, dan transparan.</p>
            <div class="hero-actions">
                <a href="{{ route('public.layanan_mandiri') }}" class="btn-hero-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:17px;height:17px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Buat Pengajuan
                </a>
                <a href="{{ route('public.cek_status') }}" class="btn-hero-ghost">Cek Status Saya <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:15px;height:15px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
            </div>
        </div>
        <div class="hero-panel">
            <div class="hero-panel-title">Fitur Tersedia</div>
            <div class="panel-item">
                <div class="panel-icon" style="background:rgba(59,130,246,0.15);"><svg fill="none" stroke="#60A5FA" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                <div><div class="panel-label">19 Jenis Surat Online</div><div class="panel-sub">Domisili, nikah, usaha, SKCK, dll</div></div>
                <div class="panel-check"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
            </div>
            <div class="panel-item">
                <div class="panel-icon" style="background:rgba(52,211,153,0.15);"><svg fill="none" stroke="#34D399" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <div><div class="panel-label">Lacak Status Real-time</div><div class="panel-sub">Dengan NIK, kapan saja</div></div>
                <div class="panel-check"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
            </div>
            <div class="panel-item">
                <div class="panel-icon" style="background:rgba(168,85,247,0.15);"><svg fill="none" stroke="#A855F7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
                <div><div class="panel-label">Arsip Digital Otomatis</div><div class="panel-sub">PDF tersimpan aman & terorganisir</div></div>
                <div class="panel-check"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
            </div>
            <div class="hero-stat-row">
                <div class="hero-stat"><strong>24/7</strong><span>Akses Online</span></div>
                <div class="hero-stat"><strong>Gratis</strong><span>Tanpa Biaya</span></div>
                <div class="hero-stat"><strong>Cepat</strong><span>Terproses</span></div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ TICKER ══════════ -->
<div class="ticker">
    <div class="ticker-track">
        <div class="ticker-item"><span class="ticker-dot"></span> Layanan Surat Online Tersedia 24 Jam</div>
        <div class="ticker-item"><span class="ticker-dot yellow"></span> Posyandu Balita Setiap Rabu Minggu Ke-2</div>
        <div class="ticker-item"><span class="ticker-dot"></span> Gotong Royong Kebersihan Lingkungan Setiap Jumat</div>
        <div class="ticker-item"><span class="ticker-dot yellow"></span> Vaksinasi Gratis di Puskesmas Pabuaran</div>
        <div class="ticker-item"><span class="ticker-dot"></span> Pendaftaran IUMK Kini Bisa Online</div>
        <div class="ticker-item"><span class="ticker-dot"></span> Layanan Surat Online Tersedia 24 Jam</div>
        <div class="ticker-item"><span class="ticker-dot yellow"></span> Posyandu Balita Setiap Rabu Minggu Ke-2</div>
        <div class="ticker-item"><span class="ticker-dot"></span> Gotong Royong Kebersihan Lingkungan Setiap Jumat</div>
        <div class="ticker-item"><span class="ticker-dot yellow"></span> Vaksinasi Gratis di Puskesmas Pabuaran</div>
        <div class="ticker-item"><span class="ticker-dot"></span> Pendaftaran IUMK Kini Bisa Online</div>
    </div>
</div>

<!-- ══════════ ABOUT ══════════ -->
<section class="about" id="tentang">
    <div class="about-grid">
        <div class="about-images reveal-left">
            <div class="about-img"><img src="https://images.unsplash.com/photo-1590005354167-6da97ce231ce?w=600&h=800&fit=crop&q=80" alt="Sawah dan Perbukitan" loading="lazy"></div>
            <div class="about-img"><img src="https://images.unsplash.com/photo-1534103138865-c70a6c04f91c?w=600&h=400&fit=crop&q=80" alt="Jalan Pedesaan" loading="lazy"></div>
            <div class="about-img"><img src="https://images.unsplash.com/photo-1505934333218-8feeaebecdc5?w=600&h=400&fit=crop&q=80" alt="Lahan Pertanian" loading="lazy"></div>
            <div class="about-badge"><strong>2004</strong>Tahun Berdiri</div>
        </div>
        <div class="about-content reveal-right">
            <div class="section-label">Tentang Desa</div>
            <h2 class="section-title" style="margin-bottom:20px;">Desa Kadubeureum, Pabuaran</h2>
            <p>Desa Kadubeureum terletak di Kecamatan Pabuaran, Kabupaten Serang, Provinsi Banten. Dikelilingi oleh hamparan sawah dan perbukitan hijau, desa ini menjadi rumah bagi masyarakat yang menjunjung tinggi nilai gotong royong dan kearifan lokal.</p>
            <p>Melalui sistem SIAPU, kami berkomitmen untuk menghadirkan pelayanan administrasi yang lebih modern, transparan, dan efisien bagi seluruh warga.</p>
            <div class="about-features">
                <div class="about-feat reveal delay-1"><div class="about-feat-icon" style="background:#EFF6FF;"><svg fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div><span>Lokasi strategis di jalur Pabuaran—Serang</span></div>
                <div class="about-feat reveal delay-2"><div class="about-feat-icon" style="background:#F0FDF4;"><svg fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div><span>Populasi ±5.200 jiwa, 12 RT / 4 RW</span></div>
                <div class="about-feat reveal delay-3"><div class="about-feat-icon" style="background:#FFFBEB;"><svg fill="none" stroke="#D97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><span>Mayoritas mata pencaharian pertanian & perdagangan</span></div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ STATS ══════════ -->
<section class="stats">
    <div class="stats-grid">
        <div class="stat-item reveal delay-1"><div class="stat-number"><span class="counter" data-target="5200">0</span><span class="stat-suffix">+</span></div><div class="stat-label">Total Warga</div></div>
        <div class="stat-item reveal delay-2"><div class="stat-number"><span class="counter" data-target="19">0</span></div><div class="stat-label">Jenis Surat Tersedia</div></div>
        <div class="stat-item reveal delay-3"><div class="stat-number"><span class="counter" data-target="12">0</span></div><div class="stat-label">RT Aktif</div></div>
        <div class="stat-item reveal delay-4"><div class="stat-number"><span class="counter" data-target="98">0</span><span class="stat-suffix">%</span></div><div class="stat-label">Tingkat Kepuasan</div></div>
    </div>
</section>

<!-- ══════════ SERVICES ══════════ -->
<section class="services" id="layanan">
    <div class="section-header reveal"><div class="section-label">Layanan Kami</div><h2 class="section-title">Semua Keperluan Administrasi dalam Satu Platform</h2><p class="section-desc">Tidak perlu antre berjam-jam. Ajukan permohonan dari rumah dan pantau prosesnya secara langsung.</p></div>
    <div class="services-grid">
        <div class="service-card reveal delay-1"><div class="service-num">01</div><div class="service-icon" style="background:#EFF6FF;"><svg fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="service-title">19 Jenis Surat Administrasi</div><p class="service-desc">Dari Surat Keterangan Domisili hingga IUMK, semua jenis surat desa bisa diajukan secara online tanpa harus antre di kantor.</p><a href="{{ route('public.layanan_mandiri') }}" class="service-link">Ajukan Sekarang →</a></div>
        <div class="service-card reveal delay-2"><div class="service-num">02</div><div class="service-icon" style="background:#F0FDF4;"><svg fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><div class="service-title">Lacak Status Permohonan</div><p class="service-desc">Pantau perkembangan pengajuan surat Anda secara langsung menggunakan Nomor Induk Kependudukan (NIK). Tidak perlu menelepon.</p><a href="{{ route('public.cek_status') }}" class="service-link">Cek Status →</a></div>
        <div class="service-card reveal delay-3"><div class="service-num">03</div><div class="service-icon" style="background:#FFF7ED;"><svg fill="none" stroke="#EA580C" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg></div><div class="service-title">Arsip Digital Otomatis</div><p class="service-desc">Setiap surat yang disetujui otomatis tersimpan sebagai arsip digital PDF. Aman, rapi, dan mudah diakses kembali kapan saja.</p><a href="{{ route('public.cek_status') }}" class="service-link">Pelajari Lebih Lanjut →</a></div>
    </div>
</section>

<!-- ══════════ HOW IT WORKS ══════════ -->
<section class="how" id="cara-kerja">
    <div class="section-header reveal"><div class="section-label">Cara Kerja</div><h2 class="section-title">Pengajuan Surat dalam 4 Langkah</h2><p class="section-desc">Mudah, cepat, dan bisa dilakukan dari mana saja.</p></div>
    <div class="steps">
        <div class="step reveal delay-1"><div class="step-num">1</div><h4>Isi Formulir</h4><p>Masukkan NIK dan data diri Anda, lalu pilih jenis surat yang ingin diajukan.</p></div>
        <div class="step reveal delay-2"><div class="step-num">2</div><h4>Kirim Permohonan</h4><p>Permohonan Anda diterima dan masuk ke antrian verifikasi petugas desa.</p></div>
        <div class="step reveal delay-3"><div class="step-num">3</div><h4>Proses Validasi</h4><p>Petugas memverifikasi data dan memproses surat sesuai prosedur yang berlaku.</p></div>
        <div class="step reveal delay-4"><div class="step-num">4</div><h4>Surat Siap</h4><p>Cek status pengajuan, dan ambil surat yang sudah jadi di kantor desa.</p></div>
    </div>
</section>

<!-- ══════════ PERSYARATAN SURAT ══════════ -->
<section class="persyaratan" id="persyaratan">
    <div class="section-header reveal"><div class="section-label">Persyaratan Dokumen</div><h2 class="section-title">Siapkan Dokumen Sebelum Mengajukan</h2><p class="section-desc">Berikut persyaratan umum untuk masing-masing jenis surat. Klik untuk melihat detail.</p></div>
    <div class="persyaratan-grid">

        <div class="persyaratan-card reveal delay-1"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Keterangan Domisili</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP</li><li>Fotokopi KK</li><li>Bukti lunas PBB (beberapa kasus)</li></ul></div></div>

        <div class="persyaratan-card reveal delay-2"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Keterangan Tidak Mampu (SKTM)</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP</li><li>Fotokopi KK</li><li>Surat permohonan atau bukti pendukung kondisi ekonomi</li></ul></div></div>

        <div class="persyaratan-card reveal delay-3"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Keterangan Usaha (SKU)</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP</li><li>Fotokopi KK</li><li>Informasi nama usaha, alamat & jenis usaha</li><li>Foto tempat usaha (opsional)</li><li>NPWP bila ada</li></ul></div></div>

        <div class="persyaratan-card reveal delay-1"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Pengantar Nikah (NA)</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Fotokopi KTP calon pengantin</li><li>Fotokopi KK calon pengantin</li><li>Surat pengantar RT/RW</li><li>Akta kelahiran</li><li>Ijazah terakhir</li><li>Pas foto terbaru</li></ul></div></div>

        <div class="persyaratan-card reveal delay-2"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Pengantar SKCK</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP</li><li>Fotokopi KK</li><li>Pas foto terbaru ukuran 4×6</li></ul></div></div>

        <div class="persyaratan-card reveal delay-3"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Keterangan Pindah</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP</li><li>Fotokopi KK</li><li>Alamat tujuan pindah</li><li>Pas foto (beberapa daerah)</li></ul></div></div>

        <div class="persyaratan-card reveal delay-1"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Keterangan Kelahiran</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP orang tua</li><li>Fotokopi KK</li><li>Surat keterangan lahir dari bidan/RS</li><li>Fotokopi buku nikah orang tua</li></ul></div></div>

        <div class="persyaratan-card reveal delay-2"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Keterangan Kematian</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP almarhum/almarhumah</li><li>Fotokopi KK</li><li>Surat keterangan kematian dari RS/dokter</li><li>Data ahli waris/pelapor</li></ul></div></div>

        <div class="persyaratan-card reveal delay-3"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Keterangan Ahli Waris</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Akta / surat kematian pewaris</li><li>Fotokopi KTP & KK pewaris</li><li>Fotokopi KTP & KK semua ahli waris</li><li>Akta kelahiran ahli waris</li><li>Buku nikah / akta nikah</li><li>Bagan silsilah keluarga</li><li>Surat pernyataan ahli waris bermeterai + 2 saksi</li></ul></div></div>

        <div class="persyaratan-card reveal delay-1"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Izin Usaha Mikro Kecil (IUMK)</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP</li><li>Fotokopi KK</li><li>Pas foto pemohon</li><li>Data usaha: nama, alamat, bidang, lama usaha</li><li>NPWP (jika ada)</li><li>Surat sewa/lokasi usaha (jika ada)</li></ul></div></div>

        <div class="persyaratan-card reveal delay-2"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Keterangan Belum Kawin</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW</li><li>Fotokopi KTP</li><li>Fotokopi KK</li><li>Akta lahir</li><li>Surat pernyataan belum menikah bermeterai (opsional)</li></ul></div></div>

        <div class="persyaratan-card reveal delay-3"><div class="persyaratan-header" onclick="this.parentElement.classList.toggle('open')"><div class="persyaratan-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div class="persyaratan-name">Surat Pengantar Izin Keramaian</div><div class="persyaratan-toggle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div></div><div class="persyaratan-body"><ul class="persyaratan-list"><li>Surat pengantar RT/RW lokasi acara</li><li>Fotokopi KTP penanggung jawab</li><li>Data acara: nama, tanggal, lokasi, jumlah peserta</li><li>Surat pernyataan tanggung jawab keamanan</li><li>Persetujuan tetangga sekitar</li></ul></div></div>

    </div>
</section>

<!-- ══════════ ARTIKEL & PANDUAN ══════════ -->
<section class="articles" id="artikel" style="background:#F8FAFC;">
    <div class="section-header reveal"><div class="section-label">Artikel & Informasi</div><h2 class="section-title">Panduan Bermanfaat untuk Warga</h2><p class="section-desc">Informasi praktis seputar pertanian, kesehatan, pendidikan, dan transportasi untuk mendukung keseharian warga desa.</p></div>
    <div class="articles-grid">
        <div class="article-card reveal delay-1" style="padding:24px;">
            <div class="article-tag" style="position:relative; display:inline-block; top:0; left:0; margin-bottom:12px; background:#16A34A;">Pertanian</div>
            <h3 class="article-title" style="font-size:18px;">Cara Membuat Pupuk Kompos dari Limbah Rumah Tangga</h3>
            <p class="article-excerpt">Limbah organik sisa dapur seperti sayuran dan kulit buah sangat baik dijadikan kompos. Kumpulkan dalam satu wadah tertutup, campurkan dengan sedikit tanah dan air beras. Diamkan selama 3-4 minggu. Pupuk ini sangat efektif menyuburkan tanaman pekarangan dan sayuran Anda tanpa biaya tambahan.</p>
        </div>
        <div class="article-card reveal delay-2" style="padding:24px;">
            <div class="article-tag" style="position:relative; display:inline-block; top:0; left:0; margin-bottom:12px; background:#EF4444;">Kesehatan</div>
            <h3 class="article-title" style="font-size:18px;">Pertolongan Pertama pada Gejala Demam Berdarah</h3>
            <p class="article-excerpt">Penyakit DBD rawan terjadi di musim hujan. Jika anggota keluarga mengalami demam tinggi mendadak selama 2-7 hari disertai nyeri sendi dan muncul bintik merah, segera berikan air putih sebanyak-banyaknya. Jangan tunggu parah, langsung bawa ke faskes terdekat untuk pemeriksaan darah rutin.</p>
        </div>
        <div class="article-card reveal delay-3" style="padding:24px;">
            <div class="article-tag" style="position:relative; display:inline-block; top:0; left:0; margin-bottom:12px; background:#F59E0B;">Transportasi & Ekonomi</div>
            <h3 class="article-title" style="font-size:18px;">Jadwal Angkutan Desa dan Distribusi Hasil Panen</h3>
            <p class="article-excerpt">Untuk memaksimalkan keuntungan hasil bumi, warga disarankan membawa hasil panen ke pasar induk pada rentang waktu 03:00 - 05:00 WIB. Angkutan desa beroperasi melayani rute distribusi dari balai desa mulai pukul 02:30 WIB setiap harinya dengan tarif standar yang telah disepakati paguyuban.</p>
        </div>
        <div class="article-card reveal delay-4" style="padding:24px;">
            <div class="article-tag" style="position:relative; display:inline-block; top:0; left:0; margin-bottom:12px; background:#3B82F6;">Pendidikan</div>
            <h3 class="article-title" style="font-size:18px;">Program Kejar Paket B & C Gratis dari Desa</h3>
            <p class="article-excerpt">Bagi warga yang putus sekolah dan ingin mendapatkan ijazah setara SMP (Paket B) atau SMA (Paket C), desa memfasilitasi kelas belajar gratis setiap akhir pekan di Balai Desa. Persyaratan hanya fotokopi KK, KTP, dan ijazah terakhir. Pendidikan adalah hak semua warga, mari manfaatkan program ini.</p>
        </div>
    </div>
</section>

<!-- ══════════ EMERGENCY ══════════ -->
<section class="emergency" id="darurat">
    <div class="emergency-inner">
        <div class="emergency-header reveal"><div class="emergency-badge">NOMOR DARURAT</div><h2>Kontak Darurat Nasional</h2><p>Simpan nomor-nomor penting ini untuk keadaan darurat atau keperluan mendesak. Layanan aktif 24 jam.</p></div>
        <div class="emergency-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
            <div class="emergency-card reveal delay-1"><div class="emergency-icon" style="background:rgba(239,68,68,0.15);"><svg fill="none" stroke="#EF4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div><div class="emergency-name">Polisi</div><a href="tel:110" class="emergency-number">110</a><div class="emergency-desc">Keamanan & Ketertiban</div></div>
            <div class="emergency-card reveal delay-2"><div class="emergency-icon" style="background:rgba(245,158,11,0.15);"><svg fill="none" stroke="#F59E0B" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg></div><div class="emergency-name">Pemadam Kebakaran</div><a href="tel:113" class="emergency-number">113</a><div class="emergency-desc">Penanganan Kebakaran</div></div>
            <div class="emergency-card reveal delay-3"><div class="emergency-icon" style="background:rgba(16,185,129,0.15);"><svg fill="none" stroke="#10B981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></div><div class="emergency-name">Ambulans / Gawat Darurat</div><a href="tel:118" class="emergency-number">118 / 119</a><div class="emergency-desc">Layanan Medis</div></div>
            <div class="emergency-card reveal delay-4"><div class="emergency-icon" style="background:rgba(59,130,246,0.15);"><svg fill="none" stroke="#3B82F6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg></div><div class="emergency-name">PLN</div><a href="tel:123" class="emergency-number">123</a><div class="emergency-desc">Gangguan Listrik</div></div>
            <div class="emergency-card reveal delay-5"><div class="emergency-icon" style="background:rgba(168,85,247,0.15);"><svg fill="none" stroke="#A855F7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg></div><div class="emergency-name">Basarnas (SAR)</div><a href="tel:115" class="emergency-number">115</a><div class="emergency-desc">Pencarian & Pertolongan</div></div>
        </div>
    </div>
</section>

<!-- ══════════ GALLERY ══════════ -->
<section class="gallery" id="galeri">
    <div class="section-header reveal"><div class="section-label">Galeri Desa</div><h2 class="section-title">Potret Kehidupan Kadubeureum</h2><p class="section-desc">Momen-momen kegiatan warga dan keindahan alam di sekitar desa kami.</p></div>
    <div class="gallery-grid">
        <div class="gallery-item reveal-scale delay-1"><img src="https://images.unsplash.com/photo-1590005354167-6da97ce231ce?w=800&h=600&fit=crop&q=80" alt="Hamparan Sawah" loading="lazy"><div class="gallery-overlay"><span>Hamparan Sawah Kadubeureum</span></div></div>
        <div class="gallery-item reveal-scale delay-2"><img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=400&h=300&fit=crop&q=80" alt="Lingkungan Hijau" loading="lazy"><div class="gallery-overlay"><span>Lingkungan Hijau Asri</span></div></div>
        <div class="gallery-item reveal-scale delay-3"><img src="https://images.unsplash.com/photo-1595981267035-7b04ca84a82d?w=400&h=300&fit=crop&q=80" alt="Jalan Pedesaan" loading="lazy"><div class="gallery-overlay"><span>Jalan Desa yang Teduh</span></div></div>
        <div class="gallery-item reveal-scale delay-4"><img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&h=300&fit=crop&q=80" alt="Pertanian Lokal" loading="lazy"><div class="gallery-overlay"><span>Pertanian Lokal</span></div></div>
        <div class="gallery-item reveal-scale delay-5"><img src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=400&h=300&fit=crop&q=80" alt="Sore di Desa" loading="lazy"><div class="gallery-overlay"><span>Senja di Pedesaan</span></div></div>
    </div>
</section>

<!-- ══════════ CTA ══════════ -->
<section class="cta-banner">
    <div class="cta-glow cta-glow-1"></div><div class="cta-glow cta-glow-2"></div>
    <div class="cta-inner reveal">
        <h2>Butuh Surat Administrasi? Mulai Sekarang!</h2>
        <p>Tidak perlu antre di kantor desa. Cukup isi formulir online, dan kami akan segera memproses permohonan Anda dengan cepat dan transparan.</p>
        <div class="cta-buttons">
            <a href="{{ route('public.layanan_mandiri') }}" class="btn-cta-white">Buat Pengajuan Surat</a>
            <a href="{{ route('public.cek_status') }}" class="btn-cta-outline">Cek Status Pengajuan</a>
        </div>
    </div>
</section>

<!-- ══════════ FOOTER ══════════ -->
<footer>
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div class="footer-brand"><div class="footer-logo">K</div><span class="footer-name">SIAPU &mdash; Kadubeureum</span></div>
                <p class="footer-about">Sistem Informasi Administrasi Pelayanan Umum Desa Kadubeureum, Kecamatan Pabuaran, Kabupaten Serang, Banten. Melayani warga dengan sepenuh hati.</p>
                <div class="footer-social">
                    <a href="#" title="Facebook"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
                    <a href="#" title="Instagram"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5" stroke-width="2"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" stroke-width="2"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2" stroke-linecap="round"/></svg></a>
                    <a href="#" title="WhatsApp"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
                </div>
            </div>
            <div class="footer-col"><h4>Layanan</h4><a href="{{ route('public.layanan_mandiri') }}">Pengajuan Surat</a><a href="{{ route('public.cek_status') }}">Cek Status</a><a href="#persyaratan">Persyaratan Surat</a><a href="#">Arsip Surat</a></div>
            <div class="footer-col"><h4>Informasi</h4><a href="#tentang">Profil Desa</a><a href="#artikel">Berita & Artikel</a><a href="#galeri">Galeri Foto</a><a href="#darurat">Kontak Darurat</a></div>
            <div class="footer-col"><h4>Kontak</h4><a href="#">Jl. Raya Pabuaran No. 123</a><a href="#">Kadubeureum, Serang 42163</a><a href="tel:02546543210">(0254) 654-3210</a><a href="mailto:desa@kadubeureum.go.id">desa@kadubeureum.go.id</a></div>
        </div>
        <div class="footer-bottom"><span>&copy; {{ date('Y') }} Desa Kadubeureum. Hak Cipta Dilindungi.</span><span>Dibangun dengan ❤ untuk masyarakat Kadubeureum</span></div>
    </div>
</footer>

<button class="scroll-top" id="scrollTop" title="Kembali ke atas" onclick="window.scrollTo({top:0,behavior:'smooth'})"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg></button>

<script>
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('mainNav');
        const scrollBtn = document.getElementById('scrollTop');
        nav.classList.toggle('scrolled', window.scrollY > 50);
        scrollBtn.classList.toggle('show', window.scrollY > 400);
    });
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); if (entry.target.querySelector('.counter')) animateCounters(entry.target); } });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach(el => observer.observe(el));
    function animateCounters(container) {
        container.querySelectorAll('.counter').forEach(counter => {
            if (counter.dataset.animated) return; counter.dataset.animated = 'true';
            const target = parseInt(counter.dataset.target), duration = 2000, step = target / (duration / 16);
            let current = 0;
            const timer = setInterval(() => { current += step; if (current >= target) { counter.textContent = target.toLocaleString('id-ID'); clearInterval(timer); } else { counter.textContent = Math.floor(current).toLocaleString('id-ID'); } }, 16);
        });
    }
    document.querySelectorAll('a[href^="#"]').forEach(a => { a.addEventListener('click', function(e) { const t = document.querySelector(this.getAttribute('href')); if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth', block: 'start' }); } }); });
</script>
</body>
</html>
