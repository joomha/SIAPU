<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Alert -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-indigo-500">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-500 mt-1 text-sm">Ini adalah ringkasan aktivitas pelayanan surat menyurat di desa Anda hari ini.</p>
                    </div>
                    <div class="hidden sm:block">
                        <svg class="w-12 h-12 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Warga</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalWarga }}</p>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Pengajuan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalPengajuan }}</p>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Surat Selesai</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pengajuanSelesai }}</p>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-50 text-yellow-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Menunggu Diproses</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pengajuanMenunggu }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Chart Area -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:col-span-2">
                    <div class="p-6 text-gray-900 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Statistik Pengajuan Surat (6 Bulan Terakhir)</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="pengajuanChart" height="100"></canvas>
                    </div>
                </div>

                <!-- Popular Services & Activity -->
                <div class="space-y-6">
                    <!-- Popular -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-100">
                            <h3 class="font-bold text-gray-800">Layanan Paling Sering Diajukan</h3>
                        </div>
                        <div class="p-0">
                            <ul class="divide-y divide-gray-100">
                                @forelse($popularSurats as $ps)
                                <li class="p-4 flex justify-between items-center hover:bg-gray-50 transition">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs mr-3">
                                            {{ $loop->iteration }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">{{ $ps->jenisSurat->nama_surat ?? 'Surat Dihapus' }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $ps->total }} kali</span>
                                </li>
                                @empty
                                <li class="p-4 text-center text-sm text-gray-500">Belum ada data pengajuan surat.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Activity Log -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Aktivitas Terkini</h3>
                            <a href="{{ route('admin.activity_log.index') }}" class="text-xs text-indigo-600 hover:underline">Lihat Semua</a>
                        </div>
                        <div class="p-4">
                            <div class="space-y-4">
                                @forelse($activities as $log)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="w-2 h-2 mt-2 rounded-full bg-indigo-500"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-800">{{ $log->description }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $log->created_at->diffForHumans() }} • oleh {{ $log->causer->name ?? 'Sistem' }}</p>
                                    </div>
                                </div>
                                @empty
                                <p class="text-sm text-gray-500 text-center">Belum ada aktivitas.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('pengajuanChart').getContext('2d');
            
            // gradient fill
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Total Pengajuan Surat',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 10,
                            titleFont: { size: 13 },
                            bodyFont: { size: 14, weight: 'bold' },
                            displayColors: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#64748b' },
                            grid: { color: '#f1f5f9', borderDash: [4, 4] }
                        },
                        x: {
                            ticks: { color: '#64748b' },
                            grid: { display: false }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
