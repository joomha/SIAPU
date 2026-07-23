<x-app-layout>
    <x-slot name="header">
        Validasi Pengajuan Surat
    </x-slot>



    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <!-- Left Pane: Info & Validation Form -->
        <div style="flex: 1; min-width: 300px; max-width: 400px;">
            <div class="card mb-6">
                <div class="card-header">
                    <h3>Data Pengajuan</h3>
                </div>
                <div class="card-body">
                    <p><strong>Warga:</strong> {{ $pengajuan_surat->warga->nama }} ({{ $pengajuan_surat->warga->nik }})</p>
                    <p><strong>Jenis Surat:</strong> {{ $pengajuan_surat->jenisSurat->nama_surat }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pengajuan_surat->tanggal_pengajuan)->format('d M Y') }}</p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="badge {{ $pengajuan_surat->status == 'Selesai' ? 'badge-green' : 'badge-yellow' }}">
                            {{ $pengajuan_surat->status }}
                        </span>
                    </p>

                    @if($pengajuan_surat->data_isian)
                        <h4 style="margin-top: 20px;">Data Isian Form</h4>
                        <div style="background: #f8fafc; padding: 12px; border-radius: 6px; font-size: 13.5px; border: 1px solid #e2e8f0; margin-top: 8px;">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @foreach($pengajuan_surat->data_isian as $key => $value)
                                    <li style="margin-bottom: 6px;">
                                        <strong style="color: #475569; text-transform: capitalize;">{{ str_replace('_', ' ', $key) }}:</strong> 
                                        <span style="color: #0f172a;">{{ $value }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h4 style="margin-top: 20px;">File Persyaratan Warga</h4>
                    @if($pengajuan_surat->file_persyaratan)
                        <ul style="padding-left: 15px; margin-top: 5px;">
                            @foreach($pengajuan_surat->file_persyaratan as $index => $file)
                                <li>
                                    <a href="{{ Storage::url($file) }}" target="_blank" style="color:#2563EB; font-size:13px;">
                                        Dokumen {{ $index + 1 }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p style="font-size: 13px; color: #666;">Tidak ada file dilampirkan.</p>
                    @endif

                    <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

                    <h4>Form Validasi</h4>
                    <form action="{{ route('admin.pengajuan-surat.validasi', $pengajuan_surat->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 15px;">
                            <label class="form-label">Tindakan</label>
                            <select name="status" class="form-input" required>
                                <option value="Diproses" {{ $pengajuan_surat->status == 'Diproses' ? 'selected' : '' }}>Diproses (Sedang dicek)</option>
                                <option value="Perlu Revisi" {{ $pengajuan_surat->status == 'Perlu Revisi' ? 'selected' : '' }}>Kembalikan ke Warga (Perlu Revisi)</option>
                                
                                @if($pengajuan_surat->jenisSurat->jenis_validasi === 'tte_kades')
                                    <option value="Menunggu Kades" {{ $pengajuan_surat->status == 'Menunggu Kades' ? 'selected' : '' }}>Teruskan ke Kades (Butuh TTE)</option>
                                @else
                                    <option value="Selesai" {{ $pengajuan_surat->status == 'Selesai' ? 'selected' : '' }}>Setujui Langsung (Selesai)</option>
                                @endif
                                
                                <option value="Ditolak" {{ $pengajuan_surat->status == 'Ditolak' ? 'selected' : '' }}>Tolak Sepenuhnya</option>
                            </select>
                            
                            @if($pengajuan_surat->jenisSurat->jenis_validasi === 'tte_kades')
                                <small style="color: #2563EB; display: block; margin-top: 5px;">* Surat ini diatur untuk wajib mendapat persetujuan & TTE Kepala Desa.</small>
                            @else
                                <small style="color: #059669; display: block; margin-top: 5px;">* Surat ini diatur agar bisa langsung disetujui Admin (tanpa Kades).</small>
                            @endif
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea name="catatan_admin" class="form-input" rows="3" placeholder="Misal: KTP kurang jelas, mohon foto ulang.">{{ $pengajuan_surat->catatan_admin }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Simpan Validasi</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Pane: Split Screen Preview -->
        <div style="flex: 2; min-width: 400px; display: flex; flex-direction: column;">
            <div class="card" style="flex: 1; display: flex; flex-direction: column;">
                
                <div class="card-header" style="display: flex; gap: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 0;">
                    <button id="tab-pdf" class="btn btn-ghost" style="border-bottom: 2px solid #2563EB; border-radius: 0; padding-bottom: 12px;" onclick="switchTab('pdf')">Preview Surat Digital</button>
                    <button id="tab-dokumen" class="btn btn-ghost" style="border-bottom: 2px solid transparent; border-radius: 0; padding-bottom: 12px;" onclick="switchTab('dokumen')">Dokumen Persyaratan</button>
                    
                    <div style="margin-left: auto; padding-top: 5px;">
                        <a href="{{ route('admin.pengajuan-surat.preview', $pengajuan_surat->id) }}" target="_blank" class="btn btn-ghost" style="padding: 4px 8px; font-size: 11px;">Buka PDF di Tab Baru</a>
                    </div>
                </div>

                <div class="card-body" style="flex: 1; padding: 0; position: relative;">
                    <!-- PDF Preview -->
                    <div id="content-pdf" style="display: block; height: 100%;">
                        <iframe src="{{ route('admin.pengajuan-surat.preview', $pengajuan_surat->id) }}" frameborder="0" style="width: 100%; height: 600px; display: block; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;"></iframe>
                    </div>

                    <!-- Dokumen Persyaratan -->
                    <div id="content-dokumen" style="display: none; height: 600px; overflow-y: auto; padding: 20px; background: #f8fafc; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
                        @if($pengajuan_surat->file_persyaratan)
                            @foreach($pengajuan_surat->file_persyaratan as $index => $file)
                                <div style="margin-bottom: 20px; background: #fff; padding: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                    <h4 style="margin-bottom: 10px; font-size: 14px; color: #334155;">Dokumen {{ $index + 1 }}</h4>
                                    @php
                                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                                    @endphp
                                    
                                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ Storage::url($file) }}" alt="Dokumen {{ $index + 1 }}" style="max-width: 100%; height: auto; border-radius: 4px; border: 1px solid #e2e8f0;">
                                    @elseif(strtolower($extension) === 'pdf')
                                        <iframe src="{{ Storage::url($file) }}" style="width: 100%; height: 400px; border: 1px solid #e2e8f0; border-radius: 4px;"></iframe>
                                    @else
                                        <a href="{{ Storage::url($file) }}" target="_blank" class="btn btn-secondary">Download Dokumen ({{ strtoupper($extension) }})</a>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center; color: #64748B; margin-top: 50px;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:48px;height:48px;margin:0 auto 10px;opacity:0.5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p>Tidak ada dokumen persyaratan yang dilampirkan oleh warga.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabId) {
            // Reset tabs
            document.getElementById('tab-pdf').style.borderColor = 'transparent';
            document.getElementById('tab-dokumen').style.borderColor = 'transparent';
            
            // Hide contents
            document.getElementById('content-pdf').style.display = 'none';
            document.getElementById('content-dokumen').style.display = 'none';
            
            // Show selected
            document.getElementById('tab-' + tabId).style.borderColor = '#2563EB';
            document.getElementById('content-' + tabId).style.display = 'block';
        }
    </script>
</x-app-layout>
