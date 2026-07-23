<x-app-layout>
    <x-slot name="header">Audit Trail / Log Aktivitas</x-slot>

    <div class="card">
        <div class="card-header">
            <h3>Daftar Aktivitas Sistem</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Aktivitas</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $activity->causer ? $activity->causer->name : 'Sistem' }}</td>
                                <td>
                                    @if($activity->description == 'created')
                                        <span class="badge" style="background:#DCFCE7;color:#16A34A;">Dibuat</span>
                                    @elseif($activity->description == 'updated')
                                        <span class="badge" style="background:#DBEAFE;color:#2563EB;">Diperbarui</span>
                                    @elseif($activity->description == 'deleted')
                                        <span class="badge" style="background:#FEE2E2;color:#DC2626;">Dihapus</span>
                                    @else
                                        <span class="badge" style="background:#F3F4F6;color:#374151;">{{ ucfirst($activity->description) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-size:13px;color:#64748B;">
                                        Tipe: {{ class_basename($activity->subject_type) }} (ID: {{ $activity->subject_id }})
                                        <br>
                                        @if($activity->properties->count() > 0)
                                            <button type="button" class="btn btn-ghost" style="padding:2px 8px;font-size:11px;margin-top:4px;" onclick="document.getElementById('props-{{ $activity->id }}').style.display = document.getElementById('props-{{ $activity->id }}').style.display === 'none' ? 'block' : 'none'">Lihat Detail</button>
                                            <pre id="props-{{ $activity->id }}" style="display:none;background:#F8FAFC;padding:8px;border-radius:4px;font-size:11px;margin-top:4px;overflow-x:auto;">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada aktivitas tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:20px;">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
