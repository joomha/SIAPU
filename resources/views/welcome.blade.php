<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAPU — Desa Kadubeureum</title>
    <meta name="description" content="Sistem Informasi Administrasi Pelayanan Umum Desa Kadubeureum, Kecamatan Pabuaran, Kabupaten Serang.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900|inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #FAFAFA; color: #1A1A2E; overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6, .nav-brand, .hero-stat strong, .stat-number, .service-title, .section-title { font-family: 'Outfit', sans-serif; }
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
        .hero-bg-video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.4; pointer-events: none; z-index: 0; filter: contrast(1.1) brightness(0.9); }
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
        .hero-panel { position: relative; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08); border-radius: 24px; padding: 32px; backdrop-filter: blur(16px); box-shadow: 0 40px 80px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.1); animation: scaleIn 0.8s ease 0.4s forwards; opacity: 0; perspective: 1200px; transform-style: preserve-3d; }
        .hero-panel::before { content: ''; position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&q=80') center/cover no-repeat; opacity: 0.75; border-radius: inherit; z-index: -1; pointer-events: none; filter: brightness(0.5) blur(1px); }
        .hero-panel-title { color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 20px; }
        .panel-item { display: flex; align-items: center; gap: 14px; padding: 16px 18px; border-radius: 14px; background: rgba(255,255,255,0.05); margin-bottom: 12px; border: 1px solid rgba(255,255,255,0.1); transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1); cursor: default; position: relative; }
        .panel-item:hover { background: rgba(255,255,255,0.1); border-color: rgba(96,165,250,0.5); transform: perspective(800px) translateY(-10px) translateZ(30px) rotateX(5deg) rotateY(-5deg) scale(1.05); box-shadow: -15px 20px 40px rgba(0,0,0,0.4), inset 1px 1px 2px rgba(255,255,255,0.3); z-index: 10; }
        .panel-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: transform 0.3s; }
        .panel-item:hover .panel-icon { transform: scale(1.1) rotate(-5deg); }
        .panel-icon svg { width: 18px; height: 18px; }
        .panel-label { color: rgba(255,255,255,0.7); font-size: 13px; font-weight: 600; }
        .panel-sub { color: rgba(255,255,255,0.3); font-size: 11px; }
        .panel-check { margin-left: auto; }
        .panel-check svg { width: 18px; height: 18px; color: #34D399; }
        .hero-stat-row { display: flex; gap: 10px; margin-top: 16px; }
        .hero-stat { flex: 1; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 16px; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); cursor: default; transform-style: preserve-3d; }
        .hero-stat:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.3); transform: translateY(-5px) translateZ(20px) scale(1.05); box-shadow: 0 15px 30px rgba(0,0,0,0.3); z-index: 10; position: relative; }
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
        .about-feat { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 10px; background: #F8FAFC; border: 1px solid #E2E8F0; transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); transform-style: preserve-3d; }
        .about-feat:hover { transform: perspective(800px) translateY(-5px) translateZ(20px) rotateX(4deg) rotateY(-2deg); border-color: #93C5FD; background: #EFF6FF; box-shadow: -10px 15px 30px rgba(37,99,235,0.15); z-index: 10; position: relative; }
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
        .service-card { border: 1.5px solid #E2E8F0; border-radius: 18px; padding: 30px; transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1); background: #fff; position: relative; overflow: visible; transform-style: preserve-3d; }
        .service-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #2563EB, #7C3AED); transform: scaleX(0); transition: transform 0.4s; transform-origin: left; }
        .service-card:hover::before { transform: scaleX(1); }
        .service-card:hover { border-color: #93C5FD; box-shadow: -15px 25px 50px rgba(37,99,235,0.15); transform: perspective(1000px) translateY(-10px) translateZ(30px) rotateX(4deg) rotateY(-3deg) scale(1.02); z-index: 10; }
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
        .step { text-align: center; padding: 28px 20px; transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); transform-style: preserve-3d; }
        .step:hover { transform: perspective(800px) translateY(-8px) translateZ(25px) rotateX(5deg) scale(1.05); }
        .step-num { width: 56px; height: 56px; border-radius: 50%; background: #0B1F3A; color: #fff; font-size: 20px; font-weight: 900; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; transition: all 0.3s; }
        .step:hover .step-num { background: #2563EB; transform: scale(1.1); box-shadow: 0 8px 24px rgba(37,99,235,0.3); }
        .step h4 { font-size: 15px; font-weight: 700; color: #0F172A; margin-bottom: 8px; }
        .step p { color: #64748B; font-size: 13.5px; line-height: 1.6; }

        /* ── PERSYARATAN SURAT ──────────────────── */
        .persyaratan { padding: 100px 40px; background: #F8FAFC; }
        .persyaratan-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; }
        .persyaratan-card { background: #fff; border: 1.5px solid #E2E8F0; border-radius: 16px; overflow: hidden; transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); transform-style: preserve-3d; }
        .persyaratan-card:hover { border-color: #93C5FD; box-shadow: -10px 20px 40px rgba(37,99,235,0.12); transform: perspective(1000px) translateY(-6px) translateZ(20px) rotateX(3deg); z-index: 5; position: relative; }
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
        .article-card { background: #fff; border-radius: 18px; overflow: hidden; border: 1px solid #E2E8F0; transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1); transform-style: preserve-3d; }
        .article-card:hover { transform: perspective(1000px) translateY(-10px) translateZ(25px) rotateX(3deg) rotateY(-2deg) scale(1.02); box-shadow: -15px 25px 50px rgba(0,0,0,0.12); border-color: #93C5FD; z-index: 10; position: relative; }
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
        .emergency-card { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 24px; text-align: center; transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); cursor: default; transform-style: preserve-3d; }
        .emergency-card:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.3); transform: perspective(800px) translateY(-8px) translateZ(25px) rotateX(5deg) scale(1.04); box-shadow: -10px 15px 30px rgba(0,0,0,0.2); z-index: 10; position: relative; }
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
            /* ── PROFIL DESA ─────────────────────────────── */
        .visi-misi { padding: 80px 40px; background: #fff; }
        .visi-card { text-align: center; max-width: 800px; margin: 0 auto 50px; padding: 40px; background: #0B1F3A; border-radius: 20px; box-shadow: 0 20px 40px rgba(11,31,58,0.15); position: relative; overflow: hidden; }
        .visi-card::before { content: ''; position: absolute; inset: 0; background: url('{{ asset('images/desa_sawah.png') }}') center/cover; opacity: 0.05; }
        .visi-card h3 { color: #60A5FA; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 12px; position: relative; }
        .visi-card h4 { font-size: 32px; font-weight: 900; color: #fff; line-height: 1.4; position: relative; }
        .misi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; max-width: 1100px; margin: 0 auto; }
        .misi-item { display: flex; gap: 16px; background: #F8FAFC; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1); transform-style: preserve-3d; }
        .misi-item:hover { transform: perspective(800px) translateY(-8px) translateZ(25px) rotateX(4deg) rotateY(-2deg) scale(1.02); border-color: #60A5FA; box-shadow: -12px 20px 40px rgba(37,99,235,0.15); background: #fff; z-index: 10; position: relative; }
        .misi-num { width: 42px; height: 42px; border-radius: 12px; background: #2563EB; color: #fff; font-size: 18px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 8px 16px rgba(37,99,235,0.2); }
        .misi-text { font-size: 14.5px; color: #475569; line-height: 1.6; padding-top: 10px; font-weight: 600; }

        .sejarah { padding: 80px 40px; background: #F8FAFC; }
        .timeline { position: relative; max-width: 900px; margin: 0 auto; padding: 20px 0; }
        .timeline::before { content: ''; position: absolute; top: 0; bottom: 0; left: 120px; width: 2px; background: #CBD5E1; }
        .tl-item { position: relative; padding-left: 170px; margin-bottom: 40px; }
        .tl-year { position: absolute; left: 0; top: 0; width: 100px; text-align: right; font-weight: 900; color: #2563EB; font-size: 22px; }
        .tl-dot { position: absolute; left: 113px; top: 6px; width: 16px; height: 16px; border-radius: 50%; background: #2563EB; border: 4px solid #F8FAFC; box-shadow: 0 0 0 3px rgba(37,99,235,0.2); transition: all 0.3s; }
        .tl-item:hover .tl-dot { transform: scale(1.3); background: #1D4ED8; }
        .tl-content { background: #fff; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1); transform-style: preserve-3d; }
        .tl-item:hover .tl-content { transform: perspective(800px) translateX(15px) translateZ(20px) rotateY(-4deg); border-color: #93C5FD; box-shadow: -15px 20px 40px rgba(0,0,0,0.1); }
        .tl-content h4 { font-size: 17px; font-weight: 800; color: #0F172A; margin-bottom: 8px; }
        .tl-content p { font-size: 14px; color: #64748B; line-height: 1.6; }

        .demografi { padding: 80px 40px; background: #fff; }
        .chart-container { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        .chart-box { background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 20px; padding: 32px; transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1); transform-style: preserve-3d; }
        .chart-box:hover { box-shadow: -15px 25px 50px rgba(0,0,0,0.08); transform: perspective(1200px) translateY(-8px) translateZ(20px) rotateX(2deg) rotateY(-1deg); z-index: 10; position: relative; }
        .chart-title { font-size: 18px; font-weight: 800; color: #0B1F3A; margin-bottom: 28px; display: flex; align-items: center; gap: 10px; }
        .chart-title svg { width: 20px; height: 20px; color: #2563EB; }
        .bar-row { margin-bottom: 18px; }
        .bar-label { display: flex; justify-content: space-between; font-size: 13.5px; font-weight: 700; color: #334155; margin-bottom: 8px; }
        .bar-track { width: 100%; height: 14px; background: #E2E8F0; border-radius: 8px; overflow: hidden; position: relative; }
        .bar-fill { height: 100%; background: linear-gradient(90deg, #3B82F6, #2563EB); border-radius: 8px; width: 0; transition: width 1.5s cubic-bezier(0.16, 1, 0.3, 1); }
        .visible .bar-fill { width: var(--w); }
        .bar-fill.green { background: linear-gradient(90deg, #10B981, #059669); }
        .bar-fill.purple { background: linear-gradient(90deg, #A855F7, #7E22CE); }
        .bar-fill.orange { background: linear-gradient(90deg, #F59E0B, #D97706); }
        
        .struktur { padding: 80px 40px; background: #F8FAFC; overflow-x: auto; }
        .org-tree { display: flex; flex-direction: column; align-items: center; min-width: 800px; padding: 20px 0; }
        .org-node { background: #0B1F3A; color: #fff; padding: 18px 30px; border-radius: 14px; text-align: center; position: relative; box-shadow: 0 10px 25px rgba(11,31,58,0.2); border-bottom: 4px solid #3B82F6; z-index: 2; margin-bottom: 40px; transition: transform 0.3s; }
        .org-node:hover { transform: perspective(800px) translateY(-8px) translateZ(30px) rotateX(6deg) scale(1.05); box-shadow: 0 15px 35px rgba(11,31,58,0.3); z-index: 10; }
        .org-node.sub { background: #fff; color: #0F172A; border: 1px solid #E2E8F0; border-bottom: 4px solid #10B981; box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
        .org-node.sub3 { border-bottom: 4px solid #F59E0B; }
        .org-title { font-size: 11px; font-weight: 800; color: #93C5FD; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px; }
        .org-node.sub .org-title { color: #64748B; }
        .org-name { font-size: 17px; font-weight: 900; letter-spacing: -0.3px; }
        .org-children { display: flex; justify-content: center; position: relative; padding-top: 40px; width: 100%; gap: 20px; }
        .org-children::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 2px; height: 40px; background: #CBD5E1; }
        .org-children.has-line::after { content: ''; position: absolute; top: 40px; left: 15%; right: 15%; height: 2px; background: #CBD5E1; }
        .org-child { position: relative; padding-top: 40px; flex: 1; display: flex; flex-direction: column; align-items: center; min-width: 180px; }
        .org-child::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 2px; height: 40px; background: #CBD5E1; }
        
        @media (max-width: 768px) {
            .chart-container { grid-template-columns: 1fr; }
            .timeline::before { left: 24px; }
            .tl-item { padding-left: 60px; }
            .tl-year { position: relative; text-align: left; margin-bottom: 12px; width: auto; font-size: 18px; }
            .tl-dot { left: 16px; top: 40px; }
            .org-tree { transform: scale(0.8); transform-origin: top center; }
        }
    
        /* ── CHATBOT UI ─────────────────────────────── */
        .float-chat { position: fixed; bottom: 85px; right: 30px; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; z-index: 999; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: pointer; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.25)); }
        .float-chat:hover { transform: translateY(-8px) scale(1.1); filter: drop-shadow(0 15px 30px rgba(0,0,0,0.35)); }
        .float-chat img { width: 100%; height: 100%; object-fit: contain; transform: scale(3.5); }
        
        .chat-window { position: fixed; bottom: 140px; right: 30px; width: 360px; height: 500px; max-height: calc(100vh - 140px); background: #fff; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); display: flex; flex-direction: column; overflow: hidden; z-index: 999; opacity: 0; transform: translateY(20px) scale(0.95); pointer-events: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1); transform-origin: bottom right; }
        .chat-window.active { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
        .chat-header { background: #0B1F3A; padding: 20px; display: flex; align-items: center; justify-content: space-between; color: #fff; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .chat-header-info { display: flex; align-items: center; gap: 12px; }
        .chat-avatar { width: 36px; height: 36px; background: #2563EB; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; }
        .chat-title { font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 15px; margin-bottom: 2px; }
        .chat-status { font-size: 11px; color: #93C5FD; display: flex; align-items: center; gap: 5px; }
        .chat-status::before { content: ''; width: 6px; height: 6px; background: #34D399; border-radius: 50%; display: inline-block; animation: pulse-glow 2s infinite; }
        .chat-close { background: none; border: none; color: #94A3B8; cursor: pointer; transition: color 0.2s; padding: 4px; }
        .chat-close:hover { color: #fff; }
        .chat-body { flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px; background: #F8FAFC; scroll-behavior: smooth; }
        .chat-msg { max-width: 85%; font-size: 13.5px; line-height: 1.6; }
        .chat-msg.bot { align-self: flex-start; background: #fff; border: 1px solid #E2E8F0; padding: 12px 16px; border-radius: 16px 16px 16px 4px; color: #1E293B; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .chat-msg.bot b { color: #2563EB; }
        .chat-msg.user { align-self: flex-end; background: #2563EB; color: #fff; padding: 12px 16px; border-radius: 16px 16px 4px 16px; box-shadow: 0 4px 12px rgba(37,99,235,0.15); }
        .chat-footer { padding: 16px; background: #fff; border-top: 1px solid #E2E8F0; display: flex; gap: 10px; align-items: center; }
        .chat-input { flex: 1; border: 1px solid #E2E8F0; border-radius: 24px; padding: 12px 16px; font-size: 14px; outline: none; transition: all 0.2s; background: #F8FAFC; }
        .chat-input:focus { border-color: #2563EB; background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .chat-send { width: 42px; height: 42px; background: #2563EB; border: none; border-radius: 50%; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0; }
        .chat-send:hover { background: #1D4ED8; transform: scale(1.05); }
        .chat-send:disabled { background: #94A3B8; cursor: not-allowed; transform: none; }
        .typing-indicator { display: none; align-self: flex-start; background: #fff; border: 1px solid #E2E8F0; padding: 12px 16px; border-radius: 16px 16px 16px 4px; gap: 4px; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .typing-indicator.active { display: flex; }
        .typing-dot { width: 6px; height: 6px; background: #94A3B8; border-radius: 50%; animation: typing 1.4s infinite ease-in-out; }
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
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
    <video autoplay loop muted playsinline class="hero-bg-video"><source src="{{ asset('latar_belakang_hero.mp4') }}" type="video/mp4"></video>
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
            <div class="about-img"><img src="{{ asset('images/desa_sawah.png') }}" alt="Sawah dan Perbukitan" loading="lazy" style="object-fit: cover; width: 100%; height: 100%;"></div>
            <div class="about-img"><img src="{{ asset('images/desa_jalan.png') }}" alt="Jalan Pedesaan" loading="lazy" style="object-fit: cover; width: 100%; height: 100%;"></div>
            <div class="about-img"><img src="{{ asset('images/desa_kantor.png') }}" alt="Kantor Desa" loading="lazy" style="object-fit: cover; width: 100%; height: 100%;"></div>
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

<!-- ══════════ VISI MISI ══════════ -->
<section class="visi-misi" id="visi-misi">
    <div class="visi-card reveal-scale">
        <h3>Visi Desa</h3>
        <h4>"DESA KADUBEUREUM MAJU DAN SEJAHTERA"</h4>
    </div>
    <div class="section-header reveal"><div class="section-label">Misi Desa</div><h2 class="section-title">Langkah Nyata Mewujudkan Visi</h2></div>
    <div class="misi-grid">
        <div class="misi-item reveal delay-1"><div class="misi-num">1</div><div class="misi-text">Meningkatkan Pembangunan Infrastruktur yang mendukung Perekonomian Desa.</div></div>
        <div class="misi-item reveal delay-2"><div class="misi-num">2</div><div class="misi-text">Meningkatkan Pembangunan di Bidang Kesehatan.</div></div>
        <div class="misi-item reveal delay-3"><div class="misi-num">3</div><div class="misi-text">Meningkatkan Pembangunan di Bidang Pendidikan.</div></div>
        <div class="misi-item reveal delay-4"><div class="misi-num">4</div><div class="misi-text">Meningkatkan Perekonomian Masyarakat Desa Kadubeureum.</div></div>
        <div class="misi-item reveal delay-5"><div class="misi-num">5</div><div class="misi-text">Meningkatkan Kinerja Aparatur Pemerintah Desa Kadubeureum.</div></div>
    </div>
</section>

<!-- ══════════ SEJARAH ══════════ -->
<section class="sejarah" id="sejarah">
    <div class="section-header reveal"><div class="section-label">Jejak Langkah</div><h2 class="section-title">Sejarah Kepemimpinan Desa</h2><p class="section-desc">Menelusuri sejarah kepemimpinan Desa Kadubeureum dari masa ke masa yang telah membawa perubahan positif bagi masyarakat.</p></div>
    <div class="timeline">
        <div class="tl-item reveal-right delay-1"><div class="tl-year">1932</div><div class="tl-dot"></div><div class="tl-content"><h4>Ki Awab</h4><p>Kepala Desa Pertama (Pemimpin pada era awal pembentukan desa)</p></div></div>
        <div class="tl-item reveal-right delay-2"><div class="tl-year">1935</div><div class="tl-dot"></div><div class="tl-content"><h4>Ki Saliman</h4><p>Kepala Desa Kedua (Menjabat dari tahun 1935 hingga 1947)</p></div></div>
        <div class="tl-item reveal-right delay-3"><div class="tl-year">1947</div><div class="tl-dot"></div><div class="tl-content"><h4>Ki Sayim</h4><p>Kepala Desa Ketiga (Memimpin desa di masa pasca-kemerdekaan hingga 1952)</p></div></div>
        <div class="tl-item reveal-right delay-4"><div class="tl-year">1952</div><div class="tl-dot"></div><div class="tl-content"><h4>Ki Marhalim</h4><p>Kepala Desa Keempat (Menjabat dari tahun 1952 hingga 1960)</p></div></div>
        <div class="tl-item reveal-right delay-5"><div class="tl-year">1960</div><div class="tl-dot"></div><div class="tl-content"><h4>H. Jahari</h4><p>Kepala Desa Kelima (Membawa perkembangan desa dari 1960 hingga 1982)</p></div></div>
        <div class="tl-item reveal-right delay-1"><div class="tl-year">1982</div><div class="tl-dot"></div><div class="tl-content"><h4>Moh. Hapi</h4><p>Kepala Desa Keenam (Menjabat dari tahun 1982 hingga 1992)</p></div></div>
        <div class="tl-item reveal-right delay-2"><div class="tl-year">1992</div><div class="tl-dot"></div><div class="tl-content"><h4>Subadri</h4><p>Kepala Desa Ketujuh (Menjabat dari tahun 1992 hingga 2000)</p></div></div>
        <div class="tl-item reveal-right delay-3"><div class="tl-year">2000</div><div class="tl-dot"></div><div class="tl-content"><h4>Suni / PJS. H. Mahrus</h4><p>Kepala Desa Kedelapan (Suni menjabat hingga 2008, dilanjutkan PJS H. Mahrus hingga 2011)</p></div></div>
        <div class="tl-item reveal-right delay-4"><div class="tl-year">2011</div><div class="tl-dot"></div><div class="tl-content"><h4>Fahrudin</h4><p>Kepala Desa Kesembilan (Menjabat dari tahun 2011 hingga 2017)</p></div></div>
        <div class="tl-item reveal-right delay-5"><div class="tl-year">2017 - Skrg</div><div class="tl-dot"></div><div class="tl-content"><h4>Mukhlas</h4><p>Kepala Desa Kesepuluh (Memimpin dengan visi "Desa Kadubeureum Maju dan Sejahtera" hingga saat ini)</p></div></div>
    </div>
</section>

<!-- ══════════ DEMOGRAFI ══════════ -->
<section class="demografi" id="demografi">
    <div class="section-header reveal"><div class="section-label">Data Penduduk</div><h2 class="section-title">Demografi Kadubeureum</h2><p class="section-desc">Gambaran statistik kependudukan Desa Kadubeureum berdasarkan data terbaru.</p></div>
    <div class="chart-container">
        
        <div class="chart-box reveal delay-1">
            <div class="chart-title"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Populasi Berdasarkan Jenis Kelamin</div>
            <div class="bar-row reveal">
                <div class="bar-label"><span>Laki-Laki (3.263 Jiwa)</span><span>51.1%</span></div>
                <div class="bar-track"><div class="bar-fill" style="--w: 51.1%;"></div></div>
            </div>
            <div class="bar-row reveal delay-2">
                <div class="bar-label"><span>Perempuan (3.119 Jiwa)</span><span>48.9%</span></div>
                <div class="bar-track"><div class="bar-fill purple" style="--w: 48.9%;"></div></div>
            </div>
        </div>
        
        <div class="chart-box reveal delay-2">
            <div class="chart-title"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg> Tingkat Pendidikan</div>
            <div class="bar-row reveal">
                <div class="bar-label"><span>Belum / Tidak Sekolah (1.615)</span><span>25.3%</span></div>
                <div class="bar-track"><div class="bar-fill orange" style="--w: 25.3%;"></div></div>
            </div>
            <div class="bar-row reveal delay-1">
                <div class="bar-label"><span>Tamat SD / Sederajat (2.593)</span><span>40.6%</span></div>
                <div class="bar-track"><div class="bar-fill green" style="--w: 40.6%;"></div></div>
            </div>
            <div class="bar-row reveal delay-2">
                <div class="bar-label"><span>SLTP / Sederajat (1.111)</span><span>17.4%</span></div>
                <div class="bar-track"><div class="bar-fill" style="--w: 17.4%;"></div></div>
            </div>
            <div class="bar-row reveal delay-3">
                <div class="bar-label"><span>SLTA / Sederajat (896)</span><span>14.0%</span></div>
                <div class="bar-track"><div class="bar-fill purple" style="--w: 14.0%;"></div></div>
            </div>
            <div class="bar-row reveal delay-4">
                <div class="bar-label"><span>Perguruan Tinggi (167)</span><span>2.7%</span></div>
                <div class="bar-track"><div class="bar-fill orange" style="--w: 2.7%;"></div></div>
            </div>
        </div>

    </div>
</section>

<!-- ══════════ STRUKTUR ORGANISASI ══════════ -->
<section class="struktur" id="struktur">
    <div class="section-header reveal"><div class="section-label">Pemerintahan</div><h2 class="section-title">Struktur Organisasi</h2><p class="section-desc">Susunan kepengurusan Pemerintah Desa Kadubeureum untuk melayani masyarakat.</p></div>
    
    <div class="org-tree reveal-scale">
        <div class="org-node">
            <div class="org-title">Kepala Desa</div>
            <div class="org-name">MUKHLAS</div>
        </div>
        
        <div class="org-children has-line">
            
            <div class="org-child">
                <div class="org-node sub reveal delay-1">
                    <div class="org-title">Sekretaris Desa</div>
                    <div class="org-name">FURIYATUL FAJRIAH</div>
                </div>
                
                <div class="org-children has-line" style="gap: 10px;">
                    <div class="org-child">
                        <div class="org-node sub sub3 reveal delay-2">
                            <div class="org-title">Kaur Tata Usaha & Umum</div>
                            <div class="org-name" style="font-size:14px;">NUR ROHMAH</div>
                        </div>
                    </div>
                    <div class="org-child">
                        <div class="org-node sub sub3 reveal delay-3">
                            <div class="org-title">Kaur Keuangan</div>
                            <div class="org-name" style="font-size:14px;">SUDRAJAT</div>
                        </div>
                    </div>
                    <div class="org-child">
                        <div class="org-node sub sub3 reveal delay-4">
                            <div class="org-title">Kaur Perencanaan</div>
                            <div class="org-name" style="font-size:14px;">ANISAH KHOIRUNISAH</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="org-children has-line" style="margin-top: -30px;">
            <div class="org-child">
                <div class="org-node sub reveal delay-3">
                    <div class="org-title">Kasi Pemerintahan</div>
                    <div class="org-name">EDI KUNAEDI</div>
                </div>
            </div>
            <div class="org-child">
                <div class="org-node sub reveal delay-4">
                    <div class="org-title">Kasi Kesejahteraan</div>
                    <div class="org-name">RUMANUDIN</div>
                </div>
            </div>
            <div class="org-child">
                <div class="org-node sub reveal delay-5">
                    <div class="org-title">Kasi Pelayanan</div>
                    <div class="org-name">ISNAIN ALFIYYAN Z</div>
                </div>
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
        <div class="gallery-item reveal-scale delay-1"><img src="{{ asset('images/desa_sawah.png') }}" alt="Hamparan Sawah" loading="lazy" style="object-fit: cover; width: 100%; height: 100%;"><div class="gallery-overlay"><span>Hamparan Sawah Kadubeureum</span></div></div>
        <div class="gallery-item reveal-scale delay-2"><img src="{{ asset('images/desa_jalan.png') }}" alt="Lingkungan Hijau" loading="lazy" style="object-fit: cover; width: 100%; height: 100%;"><div class="gallery-overlay"><span>Lingkungan Hijau Asri</span></div></div>
        <div class="gallery-item reveal-scale delay-3"><img src="{{ asset('images/desa_kantor.png') }}" alt="Jalan Pedesaan" loading="lazy" style="object-fit: cover; width: 100%; height: 100%;"><div class="gallery-overlay"><span>Jalan Desa yang Teduh</span></div></div>
        <div class="gallery-item reveal-scale delay-4"><img src="{{ asset('images/desa_sawah.png') }}" alt="Pertanian Lokal" loading="lazy" style="object-fit: cover; width: 100%; height: 100%;"><div class="gallery-overlay"><span>Pertanian Lokal</span></div></div>
        <div class="gallery-item reveal-scale delay-5"><img src="{{ asset('images/desa_jalan.png') }}" alt="Sore di Desa" loading="lazy" style="object-fit: cover; width: 100%; height: 100%;"><div class="gallery-overlay"><span>Senja di Pedesaan</span></div></div>
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

<!-- Float Chat -->
<a href="#" class="float-chat" title="Layanan Bantuan">
    <img src="{{ asset('logo_bantuan.png') }}" alt="Chat">
</a>


<div class="chat-window" id="chatWindow">
    <div class="chat-header">
        <div class="chat-header-info">
            <div class="chat-avatar">S</div>
            <div>
                <div class="chat-title">SIAPU Bot</div>
                <div class="chat-status">Online</div>
            </div>
        </div>
        <button class="chat-close" id="chatClose">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="chat-msg bot">Halo! Saya <b>SIAPU Bot</b>, asisten virtual Desa Kadubeureum. Ada yang bisa saya bantu terkait layanan desa hari ini?</div>
        <div class="typing-indicator" id="typingIndicator">
            <div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>
        </div>
    </div>
    <form class="chat-footer" id="chatForm">
        <input type="text" class="chat-input" id="chatInput" placeholder="Ketik pesan..." required autocomplete="off">
        <button type="submit" class="chat-send" id="chatSend">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="margin-left: -2px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
        </button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const floatChat = document.querySelector(".float-chat");
    const chatWindow = document.getElementById("chatWindow");
    const chatClose = document.getElementById("chatClose");
    const chatForm = document.getElementById("chatForm");
    const chatInput = document.getElementById("chatInput");
    const chatBody = document.getElementById("chatBody");
    const typingIndicator = document.getElementById("typingIndicator");
    const chatSend = document.getElementById("chatSend");

    if(floatChat && chatWindow) {
        floatChat.addEventListener("click", (e) => {
            e.preventDefault();
            chatWindow.classList.toggle("active");
            if(chatWindow.classList.contains("active")) {
                setTimeout(() => chatInput.focus(), 300);
            }
        });

        chatClose.addEventListener("click", () => {
            chatWindow.classList.remove("active");
        });

        chatForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if(!message) return;

            addMessage(message, "user");
            chatInput.value = "";
            chatSend.disabled = true;
            
            typingIndicator.classList.add("active");
            chatBody.appendChild(typingIndicator);
            chatBody.scrollTop = chatBody.scrollHeight;

            try {
                const response = await fetch("/api/chat", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").content
                    },
                    body: JSON.stringify({ message: message })
                });
                const data = await response.json();
                
                typingIndicator.classList.remove("active");
                chatSend.disabled = false;
                addMessage(data.reply, "bot");
            } catch (error) {
                typingIndicator.classList.remove("active");
                chatSend.disabled = false;
                addMessage("Maaf, terjadi kesalahan komunikasi dengan server.", "bot");
            }
        });

        function addMessage(text, sender) {
            const div = document.createElement("div");
            div.className = "chat-msg " + sender;
            div.innerHTML = text;
            chatBody.insertBefore(div, typingIndicator);
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    }
});
</script>
<!-- Sienna Accessibility -->
<script src="https://cdn.jsdelivr.net/npm/sienna-accessibility/dist/sienna-accessibility.umd.js" async></script>
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
