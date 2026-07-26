<x-app-layout>
    <x-slot name="header">Pengajuan Surat Warga</x-slot>



    <div class="card">
        <div class="card-header">
            <h3>Daftar Permohonan Masuk</h3>
            <div style="display:flex;gap:8px;align-items:center;">
                <form action="{{ route('admin.pengajuan-surat.index') }}" method="GET" style="display:flex; gap:8px;">
                    <select name="status" class="form-control" style="font-size: 13px; padding: 4px 8px; border-radius: 4px; border: 1px solid #ccc; height: auto;" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Perlu Revisi" {{ request('status') == 'Perlu Revisi' ? 'selected' : '' }}>Dikembalikan (Perlu Revisi)</option>
                        <option value="Menunggu Kades" {{ request('status') == 'Menunggu Kades' ? 'selected' : '' }}>Menunggu Kades</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $p)
                <tr>
                    <td style="color:#64748B;font-size:13px;">{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d M Y') }}</td>
                    <td>
                        <div style="font-weight:600;color:#0F172A;font-size:13.5px;">{{ $p->warga->nama }}</div>
                        <div style="font-family:monospace;font-size:11.5px;color:#94A3B8;margin-top:2px;">{{ $p->warga->nik }}</div>
                    </td>
                    <td style="font-size:13.5px;">{{ $p->jenisSurat->nama_surat }}</td>
                    <td>
                        @php
                            $statusClass = match($p->status) {
                                'Selesai'  => 'badge-green',
                                'Ditolak'  => 'badge-red',
                                'Diproses' => 'badge-blue',
                                default    => 'badge-yellow',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $p->status }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.pengajuan-surat.show', $p) }}" class="btn btn-primary" style="padding:5px 14px;font-size:12px;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Proses
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:48px;color:#94A3B8;">
                        <svg style="width:42px;height:42px;margin:0 auto 10px;display:block;opacity:0.25;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        Tidak ada pengajuan surat saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="padding:16px 22px;border-top:1px solid #F1F5F9;">
            {{ $pengajuans->links() }}
        </div>
    </div>
</x-app-layout>
