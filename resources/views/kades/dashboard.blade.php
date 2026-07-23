<x-app-layout>
    <x-slot name="header">
        Dashboard Kades - Antrean Persetujuan
    </x-slot>



    <div class="card mb-6">
        <div class="card-header">
            <h3>Antrean Surat Menunggu TTE Kades</h3>
        </div>
        <div class="card-body">
            @if($antrean->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Warga</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Catatan Admin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($antrean as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->warga->nama }}</strong><br>
                                <small>NIK: {{ $item->warga->nik }}</small>
                            </td>
                            <td>{{ $item->jenisSurat->nama_surat }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y') }}</td>
                            <td>{{ $item->catatan_admin ?? '-' }}</td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('kades.pengajuan.preview', $item->id) }}" target="_blank" class="btn btn-ghost">Lihat PDF</a>
                                    
                                    <form action="{{ route('kades.approve', $item->id) }}" method="POST" 
                                        @if($item->jenisSurat->jenis_validasi === 'tte_kades')
                                            onsubmit="if(!this.passphrase.value) { alert('Passphrase BSrE wajib diisi!'); return false; } event.preventDefault(); desaConfirm('Apakah Anda yakin ingin menandatangani surat ini secara elektronik?', () => this.submit(), 'Konfirmasi TTE'); return false;"
                                        @else
                                            onsubmit="event.preventDefault(); desaConfirm('Apakah Anda yakin ingin menyetujui surat ini?', () => this.submit(), 'Konfirmasi Persetujuan'); return false;"
                                        @endif
                                    >
                                        @csrf
                                        <input type="hidden" name="action" value="Setujui">
                                        @if($item->jenisSurat->jenis_validasi === 'tte_kades')
                                            <input type="password" name="passphrase" placeholder="Passphrase (123456)" required class="form-input" style="width: 150px; display:inline-block; font-size: 13px;" title="Masukkan Passphrase Sertifikat Elektronik Anda (Demo: 123456)">
                                            <button type="submit" class="btn btn-primary">TTE & Setujui</button>
                                        @else
                                            <button type="submit" class="btn btn-primary">Setujui</button>
                                        @endif
                                    </form>

                                    <form action="{{ route('kades.approve', $item->id) }}" method="POST" onsubmit="event.preventDefault(); desaConfirm('Apakah Anda yakin ingin menolak surat ini?', () => this.submit(), 'Konfirmasi Penolakan'); return false;">
                                        @csrf
                                        <input type="hidden" name="action" value="Tolak">
                                        <input type="text" name="catatan_admin" placeholder="Alasan penolakan" required class="form-input" style="width: 150px; display:inline-block;">
                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 15px;">
                    {{ $antrean->links() }}
                </div>
            @else
                <p>Tidak ada surat yang menunggu persetujuan Kades.</p>
            @endif
        </div>
    </div>
</x-app-layout>
