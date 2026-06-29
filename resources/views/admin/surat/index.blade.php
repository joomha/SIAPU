<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Surat Administrasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($surats as $s)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $s->nomor_surat ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $s->warga->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $s->jenisSurat->nama_surat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $s->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 
                                        ($s->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 
                                        ($s->status == 'Draft' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ $s->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if(auth()->user()->role === 'validator' && $s->status === 'Menunggu Validasi')
                                        <a href="{{ route('admin.surat.edit', $s) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Validasi</a>
                                    @elseif(auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.surat.edit', $s) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Status</a>
                                    @endif
                                    
                                    @if($s->file_surat)
                                        <a href="{{ route('admin.surat.download', $s) }}" class="text-green-600 hover:text-green-900 mr-3" target="_blank">Download PDF</a>
                                    @endif

                                    <form action="{{ route('admin.surat.destroy', $s) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada surat administrasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $surats->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
