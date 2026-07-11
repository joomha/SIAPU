<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Status - SIAPU Kadubeureum</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900|inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #FAFAFA; color: #1A1A2E; overflow-x: hidden; position: relative; cursor: none; }
        body::before { content: ''; position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background: radial-gradient(circle at top right, rgba(37,99,235,0.05), transparent 40%), radial-gradient(circle at bottom left, rgba(147,197,253,0.1), transparent 40%); z-index: -1; }
        h1, h2, h3, h4, h5, h6, .nav-brand { font-family: 'Outfit', sans-serif; }
        
        /* ── CUSTOM CURSOR ──────────────────────────── */
        .cursor-dot { width: 8px; height: 8px; background: #2563EB; border-radius: 50%; position: fixed; pointer-events: none; z-index: 9999; transform: translate(-50%, -50%); transition: width 0.2s, height 0.2s; }
        .cursor-outline { width: 40px; height: 40px; border: 2px solid rgba(37,99,235,0.5); border-radius: 50%; position: fixed; pointer-events: none; z-index: 9998; transform: translate(-50%, -50%); transition: transform 0.15s ease-out, width 0.2s, height 0.2s, background 0.2s; }
        body:hover .cursor-dot, body:hover .cursor-outline { opacity: 1; }
        a:hover ~ .cursor-outline, button:hover ~ .cursor-outline, input:hover ~ .cursor-outline, select:hover ~ .cursor-outline { transform: translate(-50%, -50%) scale(1.5); background: rgba(37,99,235,0.1); border-color: transparent; }

        /* ── ANIMATIONS ────────────────────────────── */
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }

        /* ── NAVBAR ─────────────────────────────── */
        nav { position: fixed; top: 0; width: 100%; z-index: 1000; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.3s ease; }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; height: 80px; max-width: 1200px; margin: 0 auto; padding: 0 40px; }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; cursor: none; }
        .nav-logo { width: 44px; height: 44px; border-radius: 12px; background: #2563EB; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #fff; font-size: 20px; box-shadow: 0 4px 15px rgba(37,99,235,0.3); }
        .nav-title { font-size: 22px; font-weight: 800; color: #0B1F3A; letter-spacing: -0.5px; }
        .nav-links { display: flex; gap: 32px; align-items: center; }
        .nav-link { font-size: 15px; font-weight: 600; color: #64748B; text-decoration: none; transition: all 0.3s; padding: 8px 0; position: relative; cursor: none; }
        .nav-link:hover { color: #2563EB; }
        .nav-link.active { color: #2563EB; }
        .nav-link::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: #2563EB; transition: width 0.3s ease; border-radius: 2px; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        
        /* ── PAGE HEADER ──────────────────────────── */
        .page-header { position: relative; padding: 180px 20px 100px; text-align: center; background: #0B1F3A; overflow: hidden; margin-bottom: -60px; }
        .hero-bg-video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.4; pointer-events: none; z-index: 0; filter: contrast(1.1) brightness(0.9); }
        .hero-glow-1 { position: absolute; top: -100px; right: 5%; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.25) 0%, transparent 65%); pointer-events: none; animation: float 8s ease-in-out infinite; z-index: 1; }
        .hero-glow-2 { position: absolute; bottom: -80px; left: 10%; width: 380px; height: 380px; border-radius: 50%; background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 65%); pointer-events: none; animation: float 6s ease-in-out infinite reverse; z-index: 1; }
        .header-content { position: relative; z-index: 2; }
        .page-header h1 { font-size: 42px; font-weight: 900; color: #fff; letter-spacing: -1px; margin-bottom: 16px; }
        .page-header p { font-size: 16px; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto; line-height: 1.6; }

        /* ── SEARCH CARD ──────────────────────────── */
        .search-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 24px; padding: 16px; max-width: 700px; margin: 0 auto 60px; box-shadow: 0 30px 60px rgba(0,0,0,0.12), inset 0 1px 0 rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.8); position: relative; z-index: 10; transition: transform 0.4s ease, box-shadow 0.4s ease; transform-style: preserve-3d; }
        .search-card:hover { transform: translateY(-5px); box-shadow: 0 40px 80px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.8); }
        .search-form { display: flex; gap: 12px; }
        .search-input { flex: 1; background: #F8FAFC; border: 2px solid transparent; border-radius: 16px; padding: 0 24px; font-size: 16px; color: #1E293B; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); outline: none; font-family: 'Inter', sans-serif; height: 64px; cursor: none; }
        .search-input:hover { background: #F1F5F9; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-color: rgba(37,99,235,0.3); }
        .search-input:focus { background: #fff; border-color: #2563EB; box-shadow: 0 8px 20px rgba(37,99,235,0.15); transform: translateY(-2px); }
        .btn-search { background: #0B1F3A; color: #fff; height: 64px; padding: 0 32px; border-radius: 16px; font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 16px; border: none; cursor: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 10px 20px rgba(11,31,58,0.2); white-space: nowrap; position: relative; overflow: hidden; }
        .btn-search::before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transform: translateX(-100%); transition: transform 0.6s; }
        .btn-search:hover::before { transform: translateX(100%); }
        .btn-search:hover { background: #2563EB; transform: translateY(-4px) scale(1.02); box-shadow: 0 15px 30px rgba(37,99,235,0.3); }

        /* ── ALERTS ──────────────────────────── */
        .alert-box { max-width: 700px; margin: 0 auto 30px; padding: 16px 20px; border-radius: 16px; font-size: 15px; font-weight: 500; display: flex; align-items: center; gap: 12px; position: relative; z-index: 10; }
        .alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; }
        .alert-error { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }

        /* ── RESULT CARD ──────────────────────────── */
        .result-container { max-width: 800px; margin: 0 auto 100px; position: relative; z-index: 10; }
        .result-card { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 24px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.08); border: 1px solid rgba(255,255,255,0.8); }
        .result-header { background: #F8FAFC; padding: 24px 32px; border-bottom: 1px solid #F1F5F9; }
        .result-header h3 { font-size: 18px; font-weight: 800; color: #0B1F3A; }
        .result-body { padding: 32px; }
        
        .history-list { display: flex; flex-direction: column; gap: 16px; }
        .history-item { border: 1px solid #F1F5F9; border-radius: 16px; padding: 24px; display: flex; justify-content: space-between; align-items: center; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); cursor: none; background: #fff; }
        .history-item:hover { border-color: #DBEAFE; box-shadow: 0 15px 35px rgba(37,99,235,0.1); transform: translateY(-5px) scale(1.02); }
        .history-info h4 { font-size: 17px; font-weight: 700; color: #1E293B; margin-bottom: 6px; }
        .history-info p { font-size: 14px; color: #64748B; display: flex; align-items: center; gap: 6px; }
        
        .badge { padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; letter-spacing: 0.5px; transition: transform 0.3s; }
        .history-item:hover .badge { transform: scale(1.1); }
        .badge.selesai { background: #DCFCE7; color: #166534; }
        .badge.ditolak { background: #FEE2E2; color: #991B1B; }
        .badge.diproses { background: #DBEAFE; color: #1E40AF; }
        .badge.pending { background: #FEF3C7; color: #92400E; }
        
        .empty-state { text-align: center; padding: 40px 20px; color: #94A3B8; }

        @media (max-width: 768px) {
            .nav-inner { padding: 0 20px; height: 70px; }
            .page-header { padding: 120px 20px 60px; }
            .page-header h1 { font-size: 32px; }
            .search-form { flex-direction: column; }
            .search-input, .btn-search { width: 100%; height: 56px; }
            .history-item { flex-direction: column; align-items: flex-start; gap: 16px; }
            .search-card { margin: 0 16px 40px; padding: 12px; }
            .result-container { padding: 0 16px; }
            .cursor-dot, .cursor-outline { display: none; }
        }
    </style>
</head>
<body>

    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-outline" id="cursorOutline"></div>

    <nav>
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="nav-logo">K</div>
                <div class="nav-title">KADUBEUREUM</div>
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                <a href="{{ route('public.layanan_mandiri') }}" class="nav-link">Layanan Mandiri</a>
                <a href="{{ route('public.cek_status') }}" class="nav-link active">Cek Status</a>
            </div>
        </div>
    </nav>

    <div class="page-header">
        <video autoplay loop muted playsinline class="hero-bg-video"><source src="{{ asset('latar_belakang_hero.mp4') }}" type="video/mp4"></video>
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>
        <div class="header-content">
            <h1>Cek Status Pengajuan</h1>
            <p>Ketahui perkembangan proses surat yang Anda ajukan secara transparan dengan memasukkan NIK Anda pada kolom pencarian di bawah ini.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-box alert-success">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-box alert-error">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="search-card">
        <form action="{{ route('public.cek_status') }}" method="GET" class="search-form">
            <input type="text" id="nik" name="nik" value="{{ request('nik') }}" required placeholder="Masukkan 16 Digit NIK Anda..." class="search-input">
            <button type="submit" class="btn-search">Cari Data</button>
        </form>
    </div>

    @if(request()->has('nik') && !session('error'))
        <div class="result-container">
            <div class="result-card">
                <div class="result-header">
                    <h3>Riwayat Pengajuan Surat</h3>
                </div>
                <div class="result-body">
                    @if($pengajuans->count() > 0)
                        <div class="history-list">
                            @foreach($pengajuans as $p)
                                <div class="history-item">
                                    <div class="history-info">
                                        <h4>{{ $p->jenisSurat->nama_surat }}</h4>
                                        <p>
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="badge 
                                            {{ strtolower($p->status) == 'selesai' ? 'selesai' : 
                                            (strtolower($p->status) == 'ditolak' ? 'ditolak' : 
                                            (strtolower($p->status) == 'diproses' ? 'diproses' : 'pending')) }}">
                                            {{ $p->status }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 16px; opacity: 0.5;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p>Tidak ditemukan riwayat pengajuan surat untuk NIK tersebut.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <script>
        const dot = document.getElementById('cursorDot');
        const outline = document.getElementById('cursorOutline');
        window.addEventListener('mousemove', function(e) {
            dot.style.left = e.clientX + 'px';
            dot.style.top = e.clientY + 'px';
            setTimeout(() => {
                outline.style.left = e.clientX + 'px';
                outline.style.top = e.clientY + 'px';
            }, 50);
        });
        document.querySelectorAll('a, button, input, select, textarea').forEach(el => {
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
        });
    </script>
</body>
</html>