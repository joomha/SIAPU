<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Status Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Detail Surat</h3>
                        <p><strong>Warga:</strong> {{ $surat->warga->nama }} (NIK: {{ $surat->warga->nik }})</p>
                        <p><strong>Jenis Surat:</strong> {{ $surat->jenisSurat->nama_surat }}</p>
                        <p><strong>Tanggal Surat:</strong> {{ $surat->tanggal_surat }}</p>
                    </div>

                    <form action="{{ route('admin.surat.update', $surat) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            
                            <div>
                                <x-input-label for="status" value="Status Validasi" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @if(auth()->user()->role === 'admin')
                                        <option value="Draft" {{ $surat->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Menunggu Validasi" {{ $surat->status == 'Menunggu Validasi' ? 'selected' : '' }}>Kirim untuk Validasi</option>
                                    @elseif(auth()->user()->role === 'validator')
                                        <option value="Menunggu Validasi" {{ $surat->status == 'Menunggu Validasi' ? 'selected' : '' }}>Menunggu Validasi</option>
                                        <option value="Disetujui" {{ $surat->status == 'Disetujui' ? 'selected' : '' }}>Disetujui (Generate PDF & Arsip)</option>
                                        <option value="Ditolak" {{ $surat->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    @endif
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Update Status
                            </button>
                            <a href="{{ route('admin.surat.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
