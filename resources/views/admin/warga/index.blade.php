<x-app-layout>
    <x-slot name="header">Data Warga</x-slot>

    @if(session('success'))
        <div class="alert-success">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Daftar Penduduk Terdaftar</h3>
            <div style="display:flex;gap:10px;align-items:center;">
                <form method="GET" action="{{ route('admin.warga.index') }}" style="display:flex;gap:8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK atau nama..." class="form-input" style="width:240px;">
                    <button type="submit" class="btn btn-ghost">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari
                    </button>
                </form>
                <a href="{{ route('admin.warga.create') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Warga
                </a>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Pekerjaan</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wargas as $w)
                <tr>
                    <td style="font-family:monospace;font-size:13px;color:#475569;">{{ $w->nik }}</td>
                    <td style="font-weight:600;color:#0F172A;">{{ $w->nama }}</td>
                    <td>
                        <span class="badge {{ $w->jenis_kelamin == 'Laki-laki' ? 'badge-blue' : 'badge-yellow' }}">
                            {{ $w->jenis_kelamin }}
                        </span>
                    </td>
                    <td>{{ $w->pekerjaan ?? '—' }}</td>
                    <td style="color:#64748B;font-size:13px;">RT {{ $w->rt ?? '-' }}/RW {{ $w->rw ?? '-' }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.warga.edit', $w) }}" class="btn btn-ghost" style="padding:5px 12px;font-size:12px;">Edit</a>
                            <form action="{{ route('admin.warga.destroy', $w) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data warga ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:5px 12px;font-size:12px;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:#94A3B8;">
                        <svg style="width:40px;height:40px;margin:0 auto 10px;display:block;opacity:0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        Tidak ada data warga ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="padding:16px 22px;border-top:1px solid #F1F5F9;">
            {{ $wargas->links() }}
        </div>
    </div>
</x-app-layout>
