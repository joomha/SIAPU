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
        .kop-wrapper {
            width: 100%;
            border-bottom: 4px solid #000;
            padding-bottom: 8px;
            margin-bottom: 4px;
        }
        .kop-inner {
            width: 100%;
        }
        .kop-inner td { vertical-align: middle; }
        .kop-logo-td { width: 120px; text-align: center; }
        .kop-logo-td img { width: 100px; height: auto; max-height: 110px; }
        .kop-logo-td .no-logo {
            width: 100px; height: 100px;
            border: 2px solid #000;
            display: inline-block;
            line-height: 100px;
            font-size: 9pt;
            text-align: center;
        }
        .kop-teks-td { text-align: center; padding: 0 10px; }
        .kop-teks-td p.baris1 { font-size: 11pt; margin-bottom: 0; }
        .kop-teks-td p.baris2 { font-size: 11pt; margin-bottom: 0; }
        .kop-teks-td h1 { font-size: 18pt; font-weight: bold; text-transform: uppercase; line-height: 1.2; margin: 2px 0; }
        .kop-teks-td p.alamat { font-size: 9.5pt; margin-top: 2px; }
        .kop-garis-bawah { border-bottom: 2px solid #000; margin-top: 2px; margin-bottom: 20px; }

        /* ===== JUDUL SURAT ===== */
        .judul-surat { text-align: center; margin: 20px 0 8px 0; }
        .judul-surat p.judul { font-size: 13pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .judul-surat p.nomor { font-size: 12pt; }

        /* ===== ISI SURAT ===== */
        .isi-surat { margin-top: 20px; text-align: justify; }
        .isi-surat p { margin-bottom: 10px; }

        /* ===== TABEL DATA WARGA ===== */
        .tabel-data { width: 100%; border-collapse: collapse; margin: 5px 0; }
        .tabel-data td { border: none; padding: 3px 5px; vertical-align: top; }
        .tabel-data td:first-child { width: 38%; }
        .tabel-data td:nth-child(2) { width: 5%; text-align: center; }

        /* ===== TANDA TANGAN ===== */
        .ttd-area { width: 100%; margin-top: 40px; }
        .ttd-area td { vertical-align: top; }
        .ttd-kanan { text-align: center; width: 220px; }
        .ttd-kanan .tempat-tanggal { margin-bottom: 5px; }
        .ttd-kanan .jabatan { margin-bottom: 75px; }
        .ttd-kanan .nama-kades { font-weight: bold; text-decoration: underline; }
        .ttd-kanan .nip-kades { font-size: 11pt; }

        /* ===== QR CODE ===== */
        .qr-box {
            border: 1px solid #555;
            padding: 6px;
            display: inline-block;
            text-align: center;
            margin-bottom: 5px;
        }
        .qr-box p { font-size: 8pt; color: #333; margin-top: 4px; line-height: 1.3; }
        .qr-kode-teks { font-size: 7.5pt; color: #555; margin-top: 2px; letter-spacing: 1px; }
    </style>
</head>
<body>

    {{-- ===== KOP SURAT ===== --}}
    <div class="kop-wrapper">
        <table class="kop-inner" cellpadding="0" cellspacing="0">
            <tr>
                <td class="kop-logo-td">
                    @if(config('settings.logo'))
                        <img src="{{ public_path('storage/' . config('settings.logo')) }}" alt="Logo">
                    @else
                        <div class="no-logo">LOGO</div>
                    @endif
                </td>
                <td class="kop-teks-td">
                    <p class="baris1">PEMERINTAH KABUPATEN SERANG</p>
                    <p class="baris2">KECAMATAN {{ strtoupper(config('settings.kecamatan', 'PABUARAN')) }}</p>
                    <h1>KEPALA DESA {{ strtoupper(config('settings.desa_nama', 'KADUBEUREUM')) }}</h1>
                    <p class="alamat">{{ config('settings.desa_alamat', 'Jalan Raya Palka Km. 9 Pabuaran Telp. (0254) - 250949 Kode Pos 42163') }}</p>
                </td>
            </tr>
        </table>
    </div>
    <div class="kop-garis-bawah"></div>

    {{-- ===== JUDUL SURAT ===== --}}
    <div class="judul-surat">
        <p class="judul">{{ strtoupper($pengajuan->jenisSurat->nama_surat ?? 'Surat Keterangan') }}</p>
        <p class="nomor">Nomor : {{ $pengajuan->nomor_surat ?? '......./......./ DS/' . date('Y') }}</p>
    </div>

    {{-- ===== ISI SURAT ===== --}}
    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Desa {{ config('settings.desa_nama', 'Kadubeureum') }} Kecamatan {{ config('settings.kecamatan', 'Pabuaran') }} Kabupaten Serang, menerangkan dengan sebenarnya bahwa:</p>

        <table class="tabel-data">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ $pengajuan->warga->nama }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $pengajuan->warga->nik }}</td>
            </tr>
            <tr>
                <td>Tempat, Tgl Lahir</td>
                <td>:</td>
                <td>{{ $pengajuan->warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($pengajuan->warga->tanggal_lahir)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $pengajuan->warga->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $pengajuan->warga->alamat }} RT {{ $pengajuan->warga->rt }} RW {{ $pengajuan->warga->rw }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $pengajuan->warga->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td>:</td>
                <td>{{ $pengajuan->warga->status_perkawinan ?? '-' }}</td>
            </tr>
        </table>

        <p>Berdasarkan keterangan yang ada, orang tersebut benar-benar adalah warga kami yang bertempat tinggal di alamat di atas.</p>
        <p>Surat keterangan ini dibuat untuk keperluan pengajuan dokumen administrasi. Demikian surat keterangan ini kami buat agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    {{-- ===== TANDA TANGAN ===== --}}
    <table class="ttd-area">
        <tr>
            <td>&nbsp;</td>
            <td class="ttd-kanan">
                <p class="tempat-tanggal">{{ config('settings.desa_nama', 'Kadubeureum') }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="jabatan">Kepala Desa {{ config('settings.desa_nama', 'Kadubeureum') }}</p>

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
            </td>
        </tr>
    </table>

</body>
</html>
