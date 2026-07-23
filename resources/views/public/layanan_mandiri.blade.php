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
                <select id="jenis_surat_id" name="jenis_surat_id" class="form-control" required onchange="fetchFormIsian()">
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
                    <label for="email" class="form-label">Alamat Email Aktif <span>*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: budi@gmail.com" class="form-control">
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

            <div id="dynamic-form-section" style="display: none; margin-top: 40px;">
                <h3 class="form-section-title">Data Tambahan Surat</h3>
                <div id="dynamic-form-container" class="grid-2"></div>
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

        function fetchFormIsian() {
            const id = document.getElementById('jenis_surat_id').value;
            const section = document.getElementById('dynamic-form-section');
            const container = document.getElementById('dynamic-form-container');
            container.innerHTML = '';
            
            if (!id) {
                section.style.display = 'none';
                return;
            }

            fetch(`/layanan-mandiri/form-isian/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.form_isian && Array.isArray(data.form_isian)) {
                        section.style.display = 'block';
                        data.form_isian.forEach(field => {
                            const group = document.createElement('div');
                            group.className = 'form-group';
                            if (field.type === 'textarea') {
                                group.style.gridColumn = '1 / -1'; // make textarea full width
                            }
                            
                            const label = document.createElement('label');
                            label.className = 'form-label';
                            label.innerHTML = field.label + (field.required ? ' <span>*</span>' : '');
                            
                            let input;
                            if (field.type === 'textarea') {
                                input = document.createElement('textarea');
                                input.className = 'form-control';
                                input.rows = 3;
                            } else {
                                input = document.createElement('input');
                                input.type = field.type || 'text';
                                input.className = 'form-control';
                            }
                            
                            input.name = `data_isian[${field.name}]`;
                            input.placeholder = `Masukkan ${field.label}...`;
                            if (field.required) input.required = true;
                            
                            group.appendChild(label);
                            group.appendChild(input);
                            container.appendChild(group);
                        });
                        
                        // Add hover effect listeners to new inputs
                        container.querySelectorAll('input, textarea').forEach(el => {
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
                    } else {
                        section.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error("Error fetching form_isian:", err);
                    section.style.display = 'none';
                });
        }
    </script>

    <!-- ═══ POPUP "NIAT" DESA KADUBEUREUM (Public Page) ═══ -->
    <style>
        .desa-popup-overlay { position: fixed; inset: 0; z-index: 99999; background: rgba(11, 31, 58, 0.6); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.35s ease, visibility 0.35s ease; }
        .desa-popup-overlay.active { opacity: 1; visibility: visible; }
        .desa-popup { background: #fff; border-radius: 20px; padding: 0; width: 420px; max-width: 92vw; box-shadow: 0 25px 60px rgba(0,0,0,0.25); transform: scale(0.85) translateY(20px); transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); overflow: hidden; }
        .desa-popup-overlay.active .desa-popup { transform: scale(1) translateY(0); }
        .desa-popup-header { display: flex; align-items: center; gap: 12px; padding: 20px 24px 16px; border-bottom: 1px solid #F1F5F9; }
        .desa-popup-logo { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #3B82F6, #1D4ED8); display: flex; align-items: center; justify-content: center; font-weight: 800; color: #fff; font-size: 16px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(59,130,246,0.35); }
        .desa-popup-brand strong { display: block; font-size: 14px; font-weight: 700; color: #0B1F3A; }
        .desa-popup-brand span { font-size: 11px; color: #94A3B8; font-weight: 500; }
        .desa-popup-body { padding: 28px 24px; text-align: center; }
        .desa-popup-icon { width: 72px; height: 72px; border-radius: 50%; margin: 0 auto 18px; display: flex; align-items: center; justify-content: center; transform: scale(0); transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.15s; }
        .desa-popup-overlay.active .desa-popup-icon { transform: scale(1); }
        .desa-popup-icon svg { width: 36px; height: 36px; }
        .desa-popup-icon.warning { background: #FEF9C3; }
        .desa-popup-icon.warning svg { stroke: #D97706; }
        .desa-popup-icon.error { background: #FEE2E2; }
        .desa-popup-icon.error svg { stroke: #DC2626; }
        .desa-popup-icon.success { background: #DCFCE7; }
        .desa-popup-icon.success svg { stroke: #16A34A; }
        .desa-popup-title { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; color: #0F172A; margin-bottom: 8px; }
        .desa-popup-message { font-size: 14px; color: #64748B; line-height: 1.6; }
        .desa-popup-footer { padding: 0 24px 24px; display: flex; gap: 10px; justify-content: center; }
        .desa-popup-btn { padding: 10px 28px; border-radius: 10px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s ease; font-family: 'Inter', sans-serif; }
        .desa-popup-btn.primary { background: #2563EB; color: #fff; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
        .desa-popup-btn.primary:hover { background: #1D4ED8; transform: translateY(-1px); }
        .desa-popup-btn.danger { background: #DC2626; color: #fff; }
        .desa-popup-btn.danger:hover { background: #B91C1C; }
        .desa-popup-btn.warning-btn { background: #D97706; color: #fff; box-shadow: 0 4px 12px rgba(217,119,6,0.3); }
        .desa-popup-btn.warning-btn:hover { background: #B45309; transform: translateY(-1px); }
    </style>

    <div class="desa-popup-overlay" id="desaPopupOverlayPublic">
        <div class="desa-popup">
            <div class="desa-popup-header">
                <div class="desa-popup-logo">K</div>
                <div class="desa-popup-brand">
                    <strong>SIAPU</strong>
                    <span>Desa Kadubeureum</span>
                </div>
            </div>
            <div class="desa-popup-body">
                <div class="desa-popup-icon" id="desaPopupIconPub">
                    <svg id="desaPopupSvgPub" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></svg>
                </div>
                <div class="desa-popup-title" id="desaPopupTitlePub"></div>
                <div class="desa-popup-message" id="desaPopupMsgPub"></div>
            </div>
            <div class="desa-popup-footer" id="desaPopupFooterPub"></div>
        </div>
    </div>

    <script>
        (function() {
            const overlay = document.getElementById('desaPopupOverlayPublic');
            function showPopup(type, title, message) {
                const icon = document.getElementById('desaPopupIconPub');
                const svg = document.getElementById('desaPopupSvgPub');
                document.getElementById('desaPopupTitlePub').textContent = title;
                document.getElementById('desaPopupMsgPub').textContent = message;
                icon.className = 'desa-popup-icon ' + type;
                const paths = {
                    warning: '<path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>',
                    error: '<path d="M6 18L18 6M6 6l12 12"/>',
                    success: '<path d="M5 13l4 4L19 7"/>'
                };
                svg.innerHTML = paths[type] || paths.error;
                const footer = document.getElementById('desaPopupFooterPub');
                footer.innerHTML = '';
                const btn = document.createElement('button');
                btn.className = 'desa-popup-btn ' + (type === 'warning' ? 'warning-btn' : (type === 'success' ? 'primary' : 'danger'));
                btn.textContent = 'Mengerti';
                btn.addEventListener('click', () => overlay.classList.remove('active'));
                footer.appendChild(btn);
                overlay.classList.add('active');
            }
            overlay.addEventListener('click', (e) => { if (e.target === overlay) overlay.classList.remove('active'); });

            @if(session('nik_error'))
                showPopup('warning', 'Warga Tidak Terdaftar', @json(session('nik_error')));
            @endif
        })();
    </script>
    <!-- ═══ END POPUP ═══ -->

</body>
</html>