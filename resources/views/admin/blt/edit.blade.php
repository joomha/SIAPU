<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Penerima Bantuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.blt.update', $blt) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            
                            <div>
                                <x-input-label for="warga_id" value="Pilih Warga" />
                                <select id="warga_id" name="warga_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($wargas as $w)
                                        <option value="{{ $w->id }}" {{ old('warga_id', $blt->warga_id) == $w->id ? 'selected' : '' }}>{{ $w->nik }} - {{ $w->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('warga_id')" />
                            </div>

                            <div>
                                <x-input-label for="periode" value="Periode (Contoh: Tahap I 2026)" />
                                <x-text-input id="periode" name="periode" type="text" class="mt-1 block w-full" :value="old('periode', $blt->periode)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('periode')" />
                            </div>

                            <div>
                                <x-input-label for="status_penerima" value="Status" />
                                <select id="status_penerima" name="status_penerima" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="Layak" {{ old('status_penerima', $blt->status_penerima) == 'Layak' ? 'selected' : '' }}>Layak</option>
                                    <option value="Tidak Layak" {{ old('status_penerima', $blt->status_penerima) == 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak</option>
                                    <option value="Diterima" {{ old('status_penerima', $blt->status_penerima) == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status_penerima')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Perbarui Data
                            </button>
                            <a href="{{ route('admin.blt.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
