<!DOCTYPE html>
<html>
<head>
    <title>Pemberitahuan Status Pengajuan Surat</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo, {{ $pengajuan->warga->nama }}</h2>
    <p>Ini adalah email pemberitahuan mengenai status pengajuan surat Anda di Sistem Informasi Desa.</p>
    
    <table style="width: 100%; max-width: 600px; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold; width: 30%;">Jenis Surat</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $pengajuan->jenisSurat->nama_surat ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;">Status Saat Ini</td>
            <td style="padding: 10px; border: 1px solid #ddd;"><strong>{{ $pengajuan->status }}</strong></td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9; font-weight: bold;">Tanggal Pengajuan</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d F Y') }}</td>
        </tr>
    </table>

    @if($pengajuan->catatan_admin)
    <div style="background-color: #fff3cd; color: #856404; padding: 15px; border: 1px solid #ffeeba; border-radius: 4px; margin-bottom: 20px;">
        <strong>Catatan dari Admin / Kades:</strong><br>
        {{ $pengajuan->catatan_admin }}
    </div>
    @endif

    @if($pengajuan->status === 'Selesai')
    <p>Surat Anda telah selesai diproses. <strong>File PDF dokumen surat Anda telah kami lampirkan pada email ini.</strong> Anda dapat mengunduh dan mencetaknya secara mandiri jika diperlukan.</p>
    <p>Jika surat Anda membutuhkan stempel basah atau tanda tangan fisik Kepala Desa (non-TTE), silakan datang ke Kantor Desa pada jam kerja dengan membawa dokumen persyaratan asli (jika ada).</p>
    @else
    <p>Mohon menunggu proses selanjutnya. Jika status telah "Selesai", dokumen PDF akan dilampirkan ke email Anda atau dapat diunduh melalui Portal Warga.</p>
    @endif
    
    <p>Terima kasih,<br>
    Pemerintah Desa Kadubeureum</p>
</body>
</html>
