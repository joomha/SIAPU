<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jenis Surat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.jenis-surat.update', $jenis_surat) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            
                            <div>
                                <x-input-label for="nama_surat" value="Nama Surat" />
                                <x-text-input id="nama_surat" name="nama_surat" type="text" class="mt-1 block w-full" :value="old('nama_surat', $jenis_surat->nama_surat)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_surat')" />
                            </div>

                            <div>
                                <x-input-label for="deskripsi" value="Deskripsi" />
                                <textarea id="deskripsi" name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi', $jenis_surat->deskripsi) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                            </div>

                            @php
                                $persyaratan = old('persyaratan_dokumen', $jenis_surat->persyaratan_dokumen ?? []);
                            @endphp
                            <div>
                                <x-input-label for="persyaratan_dokumen" value="Persyaratan Dokumen (Centang yang wajib)" />
                                <div class="mt-2 space-y-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="persyaratan_dokumen[]" value="KTP" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('KTP', $persyaratan) ? 'checked' : '' }}>
                                        <span class="ml-2">KTP</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="persyaratan_dokumen[]" value="KK" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('KK', $persyaratan) ? 'checked' : '' }}>
                                        <span class="ml-2">Kartu Keluarga (KK)</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="persyaratan_dokumen[]" value="Akta Kelahiran" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('Akta Kelahiran', $persyaratan) ? 'checked' : '' }}>
                                        <span class="ml-2">Akta Kelahiran</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="persyaratan_dokumen[]" value="Surat Pengantar RT/RW" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ in_array('Surat Pengantar RT/RW', $persyaratan) ? 'checked' : '' }}>
                                        <span class="ml-2">Surat Pengantar RT/RW</span>
                                    </label>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('persyaratan_dokumen')" />
                            </div>

                            <div>
                                <x-input-label for="jenis_validasi" value="Jenis Persetujuan / Validasi" />
                                <select id="jenis_validasi" name="jenis_validasi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="langsung" {{ old('jenis_validasi', $jenis_surat->jenis_validasi) === 'langsung' ? 'selected' : '' }}>Persetujuan Langsung (Admin Sahaja)</option>
                                    <option value="tte_kades" {{ old('jenis_validasi', $jenis_surat->jenis_validasi) === 'tte_kades' ? 'selected' : '' }}>Tanda Tangan Elektronik (Wajib Persetujuan Kades)</option>
                                    <option value="basah" {{ old('jenis_validasi', $jenis_surat->jenis_validasi) === 'basah' ? 'selected' : '' }}>Tanda Tangan Basah (Manual)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_validasi')" />
                            </div>

                            <div>
                                <x-input-label for="kode_surat" value="Kode Surat (Contoh: 470)" />
                                <x-text-input id="kode_surat" name="kode_surat" type="text" class="mt-1 block w-full" :value="old('kode_surat', $jenis_surat->kode_surat)" />
                                <x-input-error class="mt-2" :messages="$errors->get('kode_surat')" />
                            </div>

                            <div>
                                <x-input-label for="format_nomor" value="Format Nomor Surat (Gunakan [KODE], [NOMOR], [TAHUN])" />
                                <x-text-input id="format_nomor" name="format_nomor" type="text" class="mt-1 block w-full" :value="old('format_nomor', $jenis_surat->format_nomor)" placeholder="[KODE]/[NOMOR]/DS/[TAHUN]" />
                                <x-input-error class="mt-2" :messages="$errors->get('format_nomor')" />
                                <small class="text-gray-500">Default: [KODE]/[NOMOR]/DS/[TAHUN] (Hasil: 470/001/DS/2026)</small>
                            </div>

                            <div>
                                <x-input-label for="template_surat" value="Nama Template (View Path) *opsional" />
                                <x-text-input id="template_surat" name="template_surat" type="text" class="mt-1 block w-full" :value="old('template_surat', $jenis_surat->template_surat)" />
                                <x-input-error class="mt-2" :messages="$errors->get('template_surat')" />
                                <small class="text-gray-500">Gunakan ini jika ingin menggunakan file blade manual (contoh: surat.keterangan_usaha). Jika diisi, Template Editor di bawah akan diabaikan.</small>
                            </div>

                            <div>
                                <x-input-label for="template_konten" value="Template Editor (Dinamis)" />
                                <textarea id="template_konten" name="template_konten" class="summernote">{{ old('template_konten', $jenis_surat->template_konten) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('template_konten')" />
                                <small class="text-gray-500">Gunakan tag dinamis seperti: @{{ $warga->nama }}, @{{ $warga->nik }}, dll.</small>
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Perbarui Data
                            </button>
                            <a href="{{ route('admin.jenis-surat.index') }}" class="text-gray-600 hover:underline">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
    @endpush
</x-app-layout>
