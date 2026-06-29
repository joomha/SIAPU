<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arsip Digital') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <form method="GET" action="{{ route('admin.arsip.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK / Nama..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded ml-2">Cari</button>
                        </form>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Arsip</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($arsips as $a)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $a->tanggal_arsip }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $a->surat->nomor_surat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $a->surat->warga->nama }} <br><span class="text-xs text-gray-500">{{ $a->surat->warga->nik }}</span></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ Storage::url($a->lokasi_file) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat PDF</a>
                                    @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('admin.arsip.destroy', $a) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus arsip?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada arsip.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $arsips->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
