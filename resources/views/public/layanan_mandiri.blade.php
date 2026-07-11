<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan Mandiri - SIAPU Kadubeureum</title>
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
        a:hover ~ .cursor-outline, button:hover ~ .cursor-outline, input:hover ~ .cursor-outline, select:hover ~ .cursor-outline, textarea:hover ~ .cursor-outline { transform: translate(-50%, -50%) scale(1.5); background: rgba(37,99,235,0.1); border-color: transparent; }

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
        
        /* ── ANIMATIONS ────────────────────────────── */
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }

        /* ── PAGE HEADER ──────────────────────────── */
        .page-header { position: relative; padding: 180px 20px 100px; text-align: center; background: #0B1F3A; overflow: hidden; margin-bottom: -60px; }
        .hero-bg-video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.4; pointer-events: none; z-index: 0; filter: contrast(1.1) brightness(0.9); }
        .hero-glow-1 { position: absolute; top: -100px; right: 5%; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,0.25) 0%, transparent 65%); pointer-events: none; animation: float 8s ease-in-out infinite; z-index: 1; }
        .hero-glow-2 { position: absolute; bottom: -80px; left: 10%; width: 380px; height: 380px; border-radius: 50%; background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 65%); pointer-events: none; animation: float 6s ease-in-out infinite reverse; z-index: 1; }
        .header-content { position: relative; z-index: 2; }
        .page-header h1 { font-size: 42px; font-weight: 900; color: #fff; letter-spacing: -1px; margin-bottom: 16px; }
        .page-header p { font-size: 16px; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto; line-height: 1.6; }

        /* ── FORM CARD ──────────────────────────── */
        .form-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 24px; padding: 40px; max-width: 800px; margin: 0 auto 100px; box-shadow: 0 30px 60px rgba(0,0,0,0.12), inset 0 1px 0 rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.8); position: relative; z-index: 10; transition: transform 0.4s ease, box-shadow 0.4s ease; transform-style: preserve-3d; }
        .form-card:hover { transform: translateY(-5px); box-shadow: 0 40px 80px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.8); }
        .form-section-title { font-size: 20px; font-weight: 800; color: #0B1F3A; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 2px solid #EFF6FF; }
        
        .form-group { margin-bottom: 24px; }
        .form-label { display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px; }
        .form-label span { color: #EF4444; }
        .form-control { width: 100%; background: #F8FAFC; border: 2px solid transparent; border-radius: 12px; padding: 14px 16px; font-size: 15px; color: #1E293B; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); outline: none; font-family: 'Inter', sans-serif; cursor: none; }
        .form-control:hover { background: #F1F5F9; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-color: rgba(37,99,235,0.3); }
        .form-control:focus { background: #fff; border-color: #2563EB; box-shadow: 0 8px 20px rgba(37,99,235,0.15); transform: translateY(-2px); }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; background-size: 16px; padding-right: 40px; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        
        .btn-submit { background: #2563EB; color: #fff; padding: 16px 32px; border-radius: 12px; font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 16px; border: none; cursor: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); width: 100%; box-shadow: 0 10px 20px rgba(37,99,235,0.3); position: relative; overflow: hidden; }
        .btn-submit::before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transform: translateX(-100%); transition: transform 0.6s; }
        .btn-submit:hover::before { transform: translateX(100%); }
        .btn-submit:hover { background: #1D4ED8; transform: translateY(-4px) scale(1.02); box-shadow: 0 15px 30px rgba(37,99,235,0.4); }
        
        .alert-error { background: #FEF2F2; border: 1px solid #FCA5A5; color: #DC2626; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; font-size: 14px; }
        .alert-error ul { margin-left: 20px; margin-top: 8px; }
        
        @media (max-width: 768px) {
            .nav-inner { padding: 0 20px; height: 70px; }
            .grid-2 { grid-template-columns: 1fr; }
            .page-header { padding: 120px 20px 60px; }
            .page-header h1 { font-size: 32px; }
            .form-card { padding: 24px; margin: 0 16px 60px; }
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
                <a href="{{ route('public.layanan_mandiri') }}" class="nav-link active">Layanan Mandiri</a>
                <a href="{{ route('public.cek_status') }}" class="nav-link">Cek Status</a>
            </div>
        </div>
    </nav>

    <div class="page-header">
        <video autoplay loop muted playsinline class="hero-bg-video"><source src="{{ asset('latar_belakang_hero.mp4') }}" type="video/mp4"></video>
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>
        <div class="header-content">
            <h1>Formulir Layanan Mandiri</h1>
            <p>Silakan lengkapi formulir di bawah ini dengan data yang valid untuk mengajukan pembuatan surat administrasi desa secara online.</p>
        </div>
    </div>

    <div class="form-card">
        @if ($errors->any())
            <div class="alert-error">
                <strong>Terjadi Kesalahan!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('public.store_pengajuan') }}" method="POST">
            @csrf
            
            <h3 class="form-section-title">Informasi Surat</h3>
            <div class="form-group">
                <label for="jenis_surat_id" class="form-label">Jenis Surat yang Diajukan <span>*</span></label>
                <select id="jenis_surat_id" name="jenis_surat_id" class="form-control" required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    @foreach($jenis_surats as $js)
                        <option value="{{ $js->id }}" {{ old('jenis_surat_id') == $js->id ? 'selected' : '' }}>{{ $js->nama_surat }}</option>
                    @endforeach
                </select>
            </div>

            <h3 class="form-section-title" style="margin-top: 40px;">Data Pemohon</h3>
            <div class="grid-2">
                <div class="form-group">
                    <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK) <span>*</span></label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required maxlength="16" placeholder="16 Digit NIK" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap Sesuai KTP <span>*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Budi Santoso" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir <span>*</span></label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Contoh: Serang" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span>*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span>*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pekerjaan" class="form-label">Pekerjaan <span>*</span></label>
                    <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" required placeholder="Contoh: Wiraswasta" class="form-control">
                </div>
                <div class="form-group">
                    <label for="status_perkawinan" class="form-label">Status Perkawinan <span>*</span></label>
                    <select id="status_perkawinan" name="status_perkawinan" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>
            </div>

            <h3 class="form-section-title" style="margin-top: 40px;">Alamat Domisili</h3>
            <div class="form-group">
                <label for="alamat" class="form-label">Alamat Lengkap (Jalan, Kampung, dll) <span>*</span></label>
                <textarea id="alamat" name="alamat" required placeholder="Tuliskan alamat lengkap Anda di sini..." class="form-control">{{ old('alamat') }}</textarea>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label for="rt" class="form-label">RT <span>*</span></label>
                    <input type="text" id="rt" name="rt" value="{{ old('rt') }}" required placeholder="Contoh: 001" class="form-control">
                </div>
                <div class="form-group">
                    <label for="rw" class="form-label">RW <span>*</span></label>
                    <input type="text" id="rw" name="rw" value="{{ old('rw') }}" required placeholder="Contoh: 002" class="form-control">
                </div>
            </div>

            <div style="margin-top: 40px;">
                <button type="submit" class="btn-submit">
                    Kirim Pengajuan Surat
                </button>
            </div>
        </form>
    </div>

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