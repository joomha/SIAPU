<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $surat->jenisSurat->nama_surat }} - {{ $surat->warga->nama }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; margin: 2cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1, .kop-surat h2, .kop-surat p { margin: 0; }
        .judul-surat { text-align: center; margin-bottom: 20px; }
        .judul-surat h3 { text-decoration: underline; margin: 0; }
        .isi-surat { text-align: justify; line-height: 1.5; }
        .ttd { float: right; width: 300px; text-align: center; margin-top: 50px; }
        table { width: 100%; margin-top: 10px; margin-bottom: 10px; }
        td { vertical-align: top; padding: 3px; }
        .td-label { width: 150px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN SERANG</h2>
        <h2>KECAMATAN PABUARAN</h2>
        <h1>DESA KADUBEUREUM</h1>
        <p>Jl. Raya Pabuaran No. 123, Kodepos 42163</p>
    </div>

    <div class="judul-surat">
        <h3>{{ strtoupper($surat->jenisSurat->nama_surat) }}</h3>
        <p>Nomor: {{ $surat->nomor_surat }}</p>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini, Kepala Desa Kadubeureum, Kecamatan Pabuaran, menerangkan dengan sebenarnya bahwa:</p>
        
        <table>
            <tr><td class="td-label">Nama</td><td>: {{ $surat->warga->nama }}</td></tr>
            <tr><td class="td-label">NIK</td><td>: {{ $surat->warga->nik }}</td></tr>
            <tr><td class="td-label">Tempat, Tanggal Lahir</td><td>: {{ $surat->warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->warga->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
            <tr><td class="td-label">Jenis Kelamin</td><td>: {{ $surat->warga->jenis_kelamin }}</td></tr>
            <tr><td class="td-label">Pekerjaan</td><td>: {{ $surat->warga->pekerjaan }}</td></tr>
            <tr><td class="td-label">Alamat</td><td>: {{ $surat->warga->alamat }} RT {{ $surat->warga->rt }} / RW {{ $surat->warga->rw }}</td></tr>
        </table>

        <p>Orang tersebut di atas benar-benar warga Desa Kadubeureum yang berdomisili di alamat tersebut. Surat keterangan ini dibuat untuk keperluan administrasi sesuai dengan <strong>{{ $surat->jenisSurat->nama_surat }}</strong>.</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <p>Kadubeureum, {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</p>
        <p>Kepala Desa Kadubeureum</p>
        <br><br><br><br>
        <p><strong>( ______________________ )</strong></p>
    </div>

</body>
</html>
