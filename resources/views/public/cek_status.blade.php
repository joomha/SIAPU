<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Status - SIAPU Kadubeureum</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800">

    <nav class="w-full z-50 bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-md">K</div>
                    <span class="font-bold text-xl text-gray-900 tracking-tight">KADUBEUREUM</span>
                </a>
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Beranda</a>
                    <a href="{{ route('public.layanan_mandiri') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Layanan Mandiri</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-16 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Cek Status Pengajuan</h1>
            <p class="text-gray-600">Masukkan Nomor Induk Kependudukan (NIK) Anda untuk melihat status.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl relative mb-8 shadow-sm">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl relative mb-8 shadow-sm">
                <span class="block sm:inline font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Search Form -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8 max-w-2xl mx-auto">
            <form action="{{ route('public.cek_status') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-grow">
                    <label for="nik" class="sr-only">NIK</label>
                    <input type="text" id="nik" name="nik" value="{{ request('nik') }}" required placeholder="Masukkan 16 Digit NIK" class="w-full text-lg px-4 py-4 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm bg-gray-50">
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-indigo-700 transition shadow-md whitespace-nowrap">
                    Cari Data
                </button>
            </form>
        </div>

        @if(request()->has('nik') && !session('error'))
            
            <div class="max-w-3xl mx-auto">
                
                <!-- Pengajuan Surat -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                        <h3 class="text-lg font-bold text-indigo-900">Riwayat Pengajuan Surat</h3>
                    </div>
                    <div class="p-6">
                        @if($pengajuans->count() > 0)
                            <div class="space-y-4">
                                @foreach($pengajuans as $p)
                                    <div class="border rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $p->jenisSurat->nama_surat }}</h4>
                                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->translatedFormat('d F Y') }}</p>
                                        </div>
                                        <div>
                                            <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full 
                                                {{ $p->status == 'Selesai' ? 'bg-green-100 text-green-800' : 
                                                ($p->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 
                                                ($p->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                                {{ $p->status }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                Belum ada riwayat pengajuan surat.
                            </div>
                        @endif
                    </div>
                </div>



            </div>
        @endif

    </div>

</body>
</html>
