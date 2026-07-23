<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan Surat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Pengajuan Surat</h2>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pemohon</th>
                <th>NIK</th>
                <th>Jenis Surat</th>
                <th>Status</th>
                <th>Nomor Surat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuans as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d M Y') }}</td>
                    <td>{{ $p->warga->nama }}</td>
                    <td>{{ $p->warga->nik }}</td>
                    <td>{{ $p->jenisSurat->nama_surat }}</td>
                    <td>{{ $p->status }}</td>
                    <td>{{ $p->nomor_surat ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
