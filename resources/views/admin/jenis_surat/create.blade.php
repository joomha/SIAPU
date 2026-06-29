<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jenis Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.jenis-surat.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            
                            <div>
                                <x-input-label for="nama_surat" value="Nama Surat" />
                                <x-text-input id="nama_surat" name="nama_surat" type="text" class="mt-1 block w-full" :value="old('nama_surat')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_surat')" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi" value="Deskripsi" />
                                <textarea id="deskripsi" name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                            </div>

                            <div>
                                <x-input-label for="template_surat" value="Nama Template (View Path) *opsional" />
                                <x-text-input id="template_surat" name="template_surat" type="text" class="mt-1 block w-full" :value="old('template_surat')" />
                                <x-input-error class="mt-2" :messages="$errors->get('template_surat')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Data
                            </button>
                            <a href="{{ route('admin.jenis-surat.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
