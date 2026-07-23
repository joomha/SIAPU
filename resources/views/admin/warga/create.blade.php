<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.warga.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <x-input-label for="nik" value="NIK" />
                                <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="old('nik')" required maxlength="16" />
                                <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                            </div>

                            <div>
                                <x-input-label for="email" value="Email" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="nama" value="Nama Lengkap" />
                                <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                            </div>

                            <div>
                                <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                                <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full" :value="old('tempat_lahir')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                            </div>

                            <div>
                                <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                                <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                            </div>

                            <div>
                                <x-input-label for="pekerjaan" value="Pekerjaan" />
                                <x-text-input id="pekerjaan" name="pekerjaan" type="text" class="mt-1 block w-full" :value="old('pekerjaan')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('pekerjaan')" />
                            </div>

                            <div>
                                <x-input-label for="status_perkawinan" value="Status Perkawinan" />
                                <x-text-input id="status_perkawinan" name="status_perkawinan" type="text" class="mt-1 block w-full" :value="old('status_perkawinan')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('status_perkawinan')" />
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="alamat" value="Alamat Lengkap" />
                                <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('alamat') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                            </div>

                            <div>
                                <x-input-label for="rt" value="RT" />
                                <x-text-input id="rt" name="rt" type="text" class="mt-1 block w-full" :value="old('rt')" required maxlength="5" />
                                <x-input-error class="mt-2" :messages="$errors->get('rt')" />
                            </div>

                            <div>
                                <x-input-label for="rw" value="RW" />
                                <x-text-input id="rw" name="rw" type="text" class="mt-1 block w-full" :value="old('rw')" required maxlength="5" />
                                <x-input-error class="mt-2" :messages="$errors->get('rw')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Data
                            </button>
                            <a href="{{ route('admin.warga.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
