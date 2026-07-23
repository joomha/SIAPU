<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keaslian Surat - Desa Kadubeureum</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans antialiased">

    <div class="max-w-md w-full bg-white shadow-xl rounded-2xl overflow-hidden m-4 border border-gray-200">
        <div class="bg-primary/10 p-6 text-center border-b border-gray-100">
            <h1 class="text-xl font-bold text-gray-800 mt-2">Verifikasi Dokumen Desa</h1>
            <p class="text-sm text-gray-500 mt-1">Pemerintah Desa Kadubeureum</p>
        </div>

        <div class="p-6">
            @if(isset($valid) && $valid && isset($pengajuan))
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Dokumen Asli</h2>
                    <p class="text-gray-600 mt-2 text-sm">Surat ini sah dan tercatat dalam sistem administrasi Pemerintah Desa Kadubeureum.</p>
                </div>

                <div class="space-y-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Nomor Surat</p>
                        <p class="font-semibold text-gray-800">{{ $pengajuan->nomor_surat }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Jenis Surat</p>
                            <p class="font-medium text-gray-800">{{ $pengajuan->jenisSurat->nama_surat }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Pemohon</p>
                            <p class="font-medium text-gray-800">{{ $pengajuan->warga->nama }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Tanggal Disetujui</p>
                        <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($pengajuan->updated_at)->translatedFormat('d F Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Penandatangan</p>
                        <p class="font-medium text-gray-800 flex items-center">
                            Kepala Desa Kadubeureum
                            <svg class="w-4 h-4 text-blue-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </p>
                    </div>
                </div>
            @else
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4 animate-pulse">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Dokumen Tidak Valid</h2>
                    <p class="text-gray-600 mt-2 text-sm">Maaf, kami tidak dapat menemukan catatan untuk dokumen ini. Dokumen mungkin palsu atau telah ditarik kembali.</p>
                </div>
                
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded text-sm text-amber-800 mb-2">
                    <p class="font-semibold mb-1">Peringatan Keamanan</p>
                    <p>Penyalahgunaan atau pemalsuan dokumen negara adalah tindakan pidana. Hubungi Kantor Desa jika Anda merasa ini adalah sebuah kesalahan.</p>
                </div>
            @endif

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors focus:ring-4 focus:ring-blue-300">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
        
        <div class="bg-gray-50 p-4 text-center border-t border-gray-100 text-xs text-gray-500">
            &copy; {{ date('Y') }} Sistem Informasi Layanan Surat Desa (SIAPU).
        </div>
    </div>

</body>
</html>
