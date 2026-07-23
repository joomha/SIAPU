<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil & Dokumen Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    <form action="{{ route('warga.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- KTP Section -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="text-lg font-bold mb-2">Dokumen KTP</h3>
                                @if($warga->file_ktp)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            KTP Sudah Diunggah
                                        </span>
                                        <a href="{{ Storage::url($warga->file_ktp) }}" target="_blank" class="text-indigo-600 hover:underline text-sm ml-2">Lihat File</a>
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Belum Ada KTP
                                        </span>
                                    </div>
                                @endif
                                
                                <div>
                                    <x-input-label for="file_ktp" value="Unggah KTP Baru (JPG/PDF)" />
                                    <input type="file" name="file_ktp" id="file_ktp" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png,.pdf">
                                    <x-input-error class="mt-2" :messages="$errors->get('file_ktp')" />
                                </div>
                            </div>

                            <!-- KK Section -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="text-lg font-bold mb-2">Dokumen Kartu Keluarga (KK)</h3>
                                @if($warga->file_kk)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            KK Sudah Diunggah
                                        </span>
                                        <a href="{{ Storage::url($warga->file_kk) }}" target="_blank" class="text-indigo-600 hover:underline text-sm ml-2">Lihat File</a>
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Belum Ada KK
                                        </span>
                                    </div>
                                @endif
                                
                                <div>
                                    <x-input-label for="file_kk" value="Unggah KK Baru (JPG/PDF)" />
                                    <input type="file" name="file_kk" id="file_kk" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png,.pdf">
                                    <x-input-error class="mt-2" :messages="$errors->get('file_kk')" />
                                </div>
                            </div>

                            <!-- Akta Kelahiran Section -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="text-lg font-bold mb-2">Dokumen Akta Kelahiran</h3>
                                @if($warga->file_akta_kelahiran)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Akta Sudah Diunggah
                                        </span>
                                        <a href="{{ Storage::url($warga->file_akta_kelahiran) }}" target="_blank" class="text-indigo-600 hover:underline text-sm ml-2">Lihat File</a>
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Belum Ada Akta Kelahiran
                                        </span>
                                    </div>
                                @endif
                                
                                <div>
                                    <x-input-label for="file_akta_kelahiran" value="Unggah Akta Kelahiran Baru (JPG/PDF)" />
                                    <input type="file" name="file_akta_kelahiran" id="file_akta_kelahiran" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png,.pdf">
                                    <x-input-error class="mt-2" :messages="$errors->get('file_akta_kelahiran')" />
                                </div>
                            </div>

                            <!-- NPWP Section -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="text-lg font-bold mb-2">Dokumen NPWP</h3>
                                @if($warga->file_npwp)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            NPWP Sudah Diunggah
                                        </span>
                                        <a href="{{ Storage::url($warga->file_npwp) }}" target="_blank" class="text-indigo-600 hover:underline text-sm ml-2">Lihat File</a>
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Belum Ada NPWP
                                        </span>
                                    </div>
                                @endif
                                
                                <div>
                                    <x-input-label for="file_npwp" value="Unggah NPWP Baru (JPG/PDF)" />
                                    <input type="file" name="file_npwp" id="file_npwp" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png,.pdf">
                                    <x-input-error class="mt-2" :messages="$errors->get('file_npwp')" />
                                </div>
                            </div>

                            <!-- Pas Foto Section -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="text-lg font-bold mb-2">Pas Foto Terbaru</h3>
                                @if($warga->file_foto)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Pas Foto Sudah Diunggah
                                        </span>
                                        <a href="{{ Storage::url($warga->file_foto) }}" target="_blank" class="text-indigo-600 hover:underline text-sm ml-2">Lihat File</a>
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Belum Ada Pas Foto
                                        </span>
                                    </div>
                                @endif
                                
                                <div>
                                    <x-input-label for="file_foto" value="Unggah Pas Foto (JPG/PNG)" />
                                    <input type="file" name="file_foto" id="file_foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png">
                                    <x-input-error class="mt-2" :messages="$errors->get('file_foto')" />
                                </div>
                            </div>

                            <!-- Ijazah Section -->
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h3 class="text-lg font-bold mb-2">Dokumen Ijazah Terakhir</h3>
                                @if($warga->file_ijazah)
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Ijazah Sudah Diunggah
                                        </span>
                                        <a href="{{ Storage::url($warga->file_ijazah) }}" target="_blank" class="text-indigo-600 hover:underline text-sm ml-2">Lihat File</a>
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Belum Ada Ijazah
                                        </span>
                                    </div>
                                @endif
                                
                                <div>
                                    <x-input-label for="file_ijazah" value="Unggah Ijazah Baru (JPG/PDF)" />
                                    <input type="file" name="file_ijazah" id="file_ijazah" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png,.pdf">
                                    <x-input-error class="mt-2" :messages="$errors->get('file_ijazah')" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 hidden">
                            <button type="submit" id="submit_profil" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow-sm">
                                Simpan Profil
                            </button>
                        </div>
                    </form>

                    @push('scripts')
                    <script>
                        // Auto-submit form when a file is selected
                        document.querySelectorAll('input[type="file"]').forEach(input => {
                            input.addEventListener('change', function() {
                                if(this.files.length > 0) {
                                    // Optionally show a loading indicator here
                                    document.body.style.cursor = 'wait';
                                    this.closest('form').submit();
                                }
                            });
                        });
                    </script>
                    @endpush

                    <div class="mt-12 border-t pt-8">
                        <h3 class="text-lg font-bold mb-4">Ganti Sandi</h3>
                        <form action="{{ route('warga.ganti-sandi') }}" method="POST" class="max-w-md">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="current_password" value="Sandi Saat Ini" />
                                    <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" required />
                                </div>
                                <div>
                                    <x-input-label for="password" value="Sandi Baru" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                </div>
                                <div>
                                    <x-input-label for="password_confirmation" value="Konfirmasi Sandi Baru" />
                                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                                </div>
                                <div>
                                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded-md shadow-sm">
                                        Update Sandi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
