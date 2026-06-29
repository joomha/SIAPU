<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proses Pengajuan Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Detail Pemohon</h3>
                        <p><strong>Nama:</strong> {{ $pengajuan_surat->warga->nama }}</p>
                        <p><strong>NIK:</strong> {{ $pengajuan_surat->warga->nik }}</p>
                        <p><strong>Alamat:</strong> {{ $pengajuan_surat->warga->alamat }}, RT {{ $pengajuan_surat->warga->rt }}/RW {{ $pengajuan_surat->warga->rw }}</p>
                        <h3 class="text-lg font-semibold mt-4 mb-2">Detail Pengajuan</h3>
                        <p><strong>Jenis Surat:</strong> {{ $pengajuan_surat->jenisSurat->nama_surat }}</p>
                        <p><strong>Tanggal Pengajuan:</strong> {{ $pengajuan_surat->tanggal_pengajuan }}</p>
                    </div>

                    <form action="{{ route('admin.pengajuan-surat.update', $pengajuan_surat) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            
                            <div>
                                <x-input-label for="status" value="Status" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="Menunggu" {{ $pengajuan_surat->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Diproses" {{ $pengajuan_surat->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ $pengajuan_surat->status == 'Selesai' ? 'selected' : '' }}>Selesai (Buat Surat Administrasi otomatis)</option>
                                    <option value="Ditolak" {{ $pengajuan_surat->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div>
                                <x-input-label for="catatan" value="Catatan (opsional)" />
                                <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan', $pengajuan_surat->catatan) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('catatan')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Status
                            </button>
                            <a href="{{ route('admin.pengajuan-surat.index') }}" class="text-gray-600 hover:underline">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
