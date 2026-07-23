<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form Pengajuan Surat -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Ajukan Surat Baru</h3>
                    <form action="{{ route('warga.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="jenis_surat_id" value="Pilih Jenis Surat" />
                            <select name="jenis_surat_id" id="jenis_surat_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="fetchFormIsian()">
                                <option value="">-- Pilih Surat --</option>
                                @foreach(\App\Models\JenisSurat::all() as $js)
                                    <option value="{{ $js->id }}">{{ $js->nama_surat }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="dynamic-form-container" class="space-y-4 mb-4"></div>
                        
                        <div id="dynamic-upload-container" class="space-y-4 mb-6"></div>

                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow-sm">
                            Ajukan Surat
                        </button>
                    </form>
                </div>
            </div>

            <!-- Riwayat Pengajuan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Riwayat Pengajuan Surat</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($riwayat as $r)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $r->jenisSurat->nama_surat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($r->tanggal_pengajuan)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeColor = 'bg-yellow-100 text-yellow-800';
                                            if($r->status === 'Selesai') $badgeColor = 'bg-green-100 text-green-800';
                                            if($r->status === 'Ditolak') $badgeColor = 'bg-red-100 text-red-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                            {{ $r->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $r->catatan_admin ?? '-' }}
                                        @if($r->status === 'Perlu Revisi')
                                            <div class="mt-2 p-3 bg-red-50 rounded border border-red-100">
                                                <form action="{{ route('warga.pengajuan.revisi', $r->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <p class="text-xs font-bold text-red-600 mb-1">Unggah ulang berkas revisi:</p>
                                                    <input type="file" name="file_persyaratan[]" multiple required class="mb-2 block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded shadow-sm">Kirim Revisi</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                        Belum ada riwayat pengajuan surat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        const wargaHasKtp = {{ auth()->user()->warga->file_ktp ? 'true' : 'false' }};
        const wargaHasKk = {{ auth()->user()->warga->file_kk ? 'true' : 'false' }};
        const wargaHasAkta = {{ auth()->user()->warga->file_akta_kelahiran ? 'true' : 'false' }};
        const wargaHasNpwp = {{ auth()->user()->warga->file_npwp ? 'true' : 'false' }};
        const wargaHasFoto = {{ auth()->user()->warga->file_foto ? 'true' : 'false' }};
        const wargaHasIjazah = {{ auth()->user()->warga->file_ijazah ? 'true' : 'false' }};

        function fetchFormIsian() {
            const id = document.getElementById('jenis_surat_id').value;
            const container = document.getElementById('dynamic-form-container');
            const uploadContainer = document.getElementById('dynamic-upload-container');
            
            container.innerHTML = ''; // Clear existing
            uploadContainer.innerHTML = '';
            
            if (!id) return;

            fetch(`/warga/pengajuan/form-isian/${id}`)
                .then(res => res.json())
                .then(data => {
                    // Render Form Isian
                    if (data.form_isian && Array.isArray(data.form_isian)) {
                        data.form_isian.forEach(field => {
                            const div = document.createElement('div');
                            
                            const label = document.createElement('label');
                            label.className = 'block font-medium text-sm text-gray-700 mb-1';
                            label.innerText = field.label + (field.required ? ' *' : '');
                            
                            let input;
                            if (field.type === 'textarea') {
                                input = document.createElement('textarea');
                                input.rows = 3;
                            } else {
                                input = document.createElement('input');
                                input.type = field.type || 'text';
                            }
                            
                            input.name = `data_isian[${field.name}]`;
                            input.className = 'mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm';
                            
                            if (field.required) {
                                input.required = true;
                            }
                            
                            div.appendChild(label);
                            div.appendChild(input);
                            container.appendChild(div);
                        });
                    }

                    // Render Dynamic Upload Requirements
                    if (data.persyaratan_dokumen && Array.isArray(data.persyaratan_dokumen)) {
                        let uploadNeeded = false;
                        const reqHeader = document.createElement('h4');
                        reqHeader.className = 'text-sm font-bold text-gray-700 border-b pb-2 mt-4 mb-2';
                        reqHeader.innerText = 'Persyaratan Berkas Tambahan:';
                        uploadContainer.appendChild(reqHeader);

                        data.persyaratan_dokumen.forEach(doc => {
                            // Check if Warga already has the document in their profile
                            let hasDoc = false;
                            let docLower = doc.toLowerCase();
                            
                            if (docLower.includes('ktp') && wargaHasKtp) hasDoc = true;
                            else if (docLower.includes('kk') && wargaHasKk) hasDoc = true;
                            else if ((docLower.includes('akta lahir') || docLower.includes('akta kelahiran')) && wargaHasAkta) hasDoc = true;
                            else if (docLower.includes('npwp') && wargaHasNpwp) hasDoc = true;
                            else if ((docLower.includes('pas foto') || docLower.includes('pas photo') || docLower.includes('foto')) && wargaHasFoto) hasDoc = true;
                            else if (docLower.includes('ijazah') && wargaHasIjazah) hasDoc = true;

                            if (hasDoc) {
                                // Just show a green checkmark indicating it will be pulled from profile
                                const div = document.createElement('div');
                                div.className = 'text-sm text-green-700 flex items-center gap-2 mb-2 bg-green-50 p-2 rounded';
                                div.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                                                 <b>${doc}</b> sudah ada di Profil Anda.`;
                                uploadContainer.appendChild(div);
                            } else {
                                // Need to upload this specific document
                                uploadNeeded = true;
                                const div = document.createElement('div');
                                div.className = 'mb-3';
                                
                                const label = document.createElement('label');
                                label.className = 'block font-medium text-sm text-gray-700 mb-1';
                                label.innerText = `Unggah ${doc} *`;
                                
                                const input = document.createElement('input');
                                input.type = 'file';
                                input.name = 'file_persyaratan[]';
                                input.required = true;
                                input.className = 'mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100';
                                input.accept = '.jpg,.jpeg,.png,.pdf';
                                
                                div.appendChild(label);
                                div.appendChild(input);
                                uploadContainer.appendChild(div);
                            }
                        });

                        if (!uploadNeeded) {
                            const note = document.createElement('p');
                            note.className = 'text-sm text-gray-500 italic mt-2';
                            note.innerText = 'Semua persyaratan dokumen wajib sudah lengkap dari profil Anda.';
                            uploadContainer.appendChild(note);
                        }
                    } else {
                        // Fallback to general upload if no structured requirements
                        const div = document.createElement('div');
                        const label = document.createElement('label');
                        label.className = 'block font-medium text-sm text-gray-700 mb-1';
                        label.innerText = 'Upload Persyaratan Tambahan (KTP/KK dll) Jika Ada';
                        
                        const input = document.createElement('input');
                        input.type = 'file';
                        input.name = 'file_persyaratan[]';
                        input.multiple = true;
                        input.className = 'mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100';
                        
                        div.appendChild(label);
                        div.appendChild(input);
                        uploadContainer.appendChild(div);
                    }
                })
                .catch(err => console.error("Error fetching form_isian:", err));
        }
    </script>
    @endpush
</x-app-layout>
