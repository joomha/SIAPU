<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $pengajuan->jenisSurat->nama_surat ?? 'Surat Keterangan' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            margin: 1.5cm 2cm 1.5cm 2.5cm;
        }

        /* ===== KOP SURAT ===== */
        .kop-surat {
            display: table;
            width: 100%;
            border-bottom: 4px solid #000;
            padding-bottom: 8px;
            margin-bottom: 4px;
        }
        .kop-surat::after {
            content: '';
            display: table;
            clear: both;
        }
        .kop-logo {
            display: table-cell;
            width: 120px;
            vertical-align: middle;
            text-align: center;
        }
        .kop-logo img {
            width: 100px;
            height: auto;
            max-height: 110px;
        }
        .kop-logo .no-logo {
            width: 100px;
            height: 100px;
            border: 2px solid #000;
            display: inline-block;
            line-height: 100px;
            font-size: 9pt;
            text-align: center;
        }
        .kop-teks {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }
        .kop-teks p.baris1 {
            font-size: 11pt;
            font-weight: normal;
            margin-bottom: 0;
        }
        .kop-teks p.baris2 {
            font-size: 11pt;
            font-weight: normal;
            margin-bottom: 0;
        }
        .kop-teks h1 {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.2;
            margin: 2px 0;
        }
        .kop-teks p.alamat {
            font-size: 9.5pt;
            margin-top: 2px;
        }
        .kop-garis-bawah {
            border-bottom: 2px solid #000;
            margin-top: 2px;
            margin-bottom: 20px;
        }

        /* ===== JUDUL SURAT ===== */
        .judul-surat {
            text-align: center;
            margin: 20px 0 8px 0;
        }
        .judul-surat p.judul {
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .judul-surat p.nomor {
            font-size: 12pt;
        }

        /* ===== ISI SURAT ===== */
        .isi-surat {
            margin-top: 20px;
            text-align: justify;
        }
        .isi-surat p {
            margin-bottom: 10px;
        }

        /* ===== TABEL DATA WARGA ===== */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .tabel-data td {
            border: none;
            padding: 2px 5px;
            vertical-align: top;
        }
        .tabel-data td:first-child {
            width: 38%;
        }
        .tabel-data td:nth-child(2) {
            width: 5%;
            text-align: center;
        }

        /* ===== TANDA TANGAN ===== */
        .ttd-area {
            margin-top: 40px;
            width: 100%;
        }
        .ttd-area::after { content: ''; display: table; clear: both; }
        .ttd-kiri {
            float: left;
            width: 50%;
        }
        .ttd-kanan {
            float: right;
            width: 50%;
            text-align: center;
        }
        .ttd-kanan .tempat-tanggal {
            text-align: center;
            margin-bottom: 5px;
            font-size: 12pt;
        }
        .ttd-kanan .jabatan {
            font-size: 12pt;
            margin-bottom: 80px;
        }
        .ttd-kanan .nama-kades {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
        }
        .ttd-kanan .nip-kades {
            font-size: 11pt;
        }

        /* ===== QR CODE BOX ===== */
        .qr-box {
            border: 1px solid #555;
            padding: 8px;
            display: inline-block;
            text-align: center;
            margin-bottom: 5px;
        }
        .qr-box img {
            display: block;
            margin: 0 auto;
        }
        .qr-box p {
            font-size: 8pt;
            color: #333;
            margin-top: 4px;
            line-height: 1.3;
        }
        .qr-kode-teks {
            font-size: 8pt;
            color: #555;
            margin-top: 3px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    {{-- ===== KOP SURAT ===== --}}
    <div class="kop-surat">
        <div class="kop-logo">
            @if(config('settings.logo'))
                <img src="{{ public_path('storage/' . config('settings.logo')) }}" alt="Logo Desa">
            @else
                <div class="no-logo">LOGO</div>
            @endif
        </div>
        <div class="kop-teks">
            <p class="baris1">PEMERINTAH KABUPATEN SERANG</p>
            <p class="baris2">KECAMATAN {{ strtoupper(config('settings.kecamatan', 'PABUARAN')) }}</p>
            <h1>KEPALA DESA {{ strtoupper(config('settings.desa_nama', 'KADUBEUREUM')) }}</h1>
            <p class="alamat">{{ config('settings.desa_alamat', 'Jalan Raya Palka Km. 9 Pabuaran Telp. (0254) - 250949 Kode Pos 42163') }}</p>
        </div>
    </div>
    <div class="kop-garis-bawah"></div>

    {{-- ===== JUDUL SURAT ===== --}}
    <div class="judul-surat">
        <p class="judul">{{ strtoupper($pengajuan->jenisSurat->nama_surat ?? 'Surat Keterangan') }}</p>
        <p class="nomor">Nomor : {{ $pengajuan->nomor_surat ?? '......./......./ DS/' . date('Y') }}</p>
    </div>

    {{-- ===== ISI SURAT DINAMIS ===== --}}
    <div class="isi-surat">
        {!! $konten !!}
    </div>

    {{-- ===== AREA TANDA TANGAN ===== --}}
    <div class="ttd-area">
        <div class="ttd-kiri">
            {{-- Kosong atau bisa diisi keperluan lain --}}
        </div>
        <div class="ttd-kanan">
            <p class="tempat-tanggal">{{ config('settings.desa_nama', 'Kadubeureum') }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p class="jabatan">Kepala Desa {{ config('settings.desa_nama', 'Kadubeureum') }}</p>

            {{-- QR Code TTE --}}
            @if(isset($pengajuan) && $pengajuan->status == 'Selesai' && $pengajuan->kode_verifikasi && $pengajuan->jenisSurat->jenis_validasi == 'tte_kades')
                <div class="qr-box">
                    <img src="data:image/svg+xml;base64,{!! base64_encode(QrCode::format('svg')->size(90)->errorCorrection('M')->generate(url('/verify/' . $pengajuan->kode_verifikasi))) !!}" width="90" height="90" alt="QR Code TTE">
                    <p>Telah Ditandatangani<br>Secara Elektronik</p>
                </div>
                <p class="qr-kode-teks">{{ $pengajuan->kode_verifikasi }}</p>
            @else
                <br><br><br><br>
            @endif

            <p class="nama-kades">{{ strtoupper(config('settings.kades_nama', 'NAMA KEPALA DESA')) }}</p>
            @if(config('settings.kades_nip'))
                <p class="nip-kades">NIP. {{ config('settings.kades_nip') }}</p>
            @endif
        </div>
    </div>

</body>
</html>
