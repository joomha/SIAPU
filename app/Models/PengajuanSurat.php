<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PengajuanSurat extends Model
{
    use LogsActivity;

    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'catatan_admin', 'nomor_surat'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected function casts(): array
    {
        return [
            'file_persyaratan' => 'array',
            'data_isian' => 'array',
        ];
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function generatePdf()
    {
        $viewName = $this->jenisSurat->template_surat;
        if (empty($viewName) && !empty($this->jenisSurat->template_konten)) {
            $viewName = 'pdf.dynamic';
        } elseif (!view()->exists($viewName)) {
            $viewName = 'pdf.default';
        }

        $konten = '';
        if ($viewName === 'pdf.dynamic') {
            $warga = $this->warga;
            $tanggal_lahir = $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y') : '-';
            $isian = is_array($this->data_isian) ? $this->data_isian : json_decode($this->data_isian, true) ?? [];
            
            $replaces = [
                '{{ $warga->nama }}' => $warga->nama ?? '-',
                '{{ $warga->nik }}' => $warga->nik ?? '-',
                '{{ $warga->nomor_kk }}' => $warga->nomor_kk ?? '-',
                '{{ $warga->tempat_lahir }}' => $warga->tempat_lahir ?? '-',
                '{{ $warga->tanggal_lahir }}' => $tanggal_lahir,
                '{{ $warga->jenis_kelamin }}' => ($warga->jenis_kelamin === 'L' || $warga->jenis_kelamin === 'Laki-Laki') ? 'Laki-Laki' : 'Perempuan',
                '{{ $warga->agama }}' => $warga->agama ?? '-',
                '{{ $warga->pekerjaan }}' => $warga->pekerjaan ?? '-',
                '{{ $warga->alamat }}' => $warga->alamat ?? '-',
                '{{ $warga->rt }}' => $warga->rt ?? '-',
                '{{ $warga->rw }}' => $warga->rw ?? '-',
                '{{ $warga->telepon }}' => $warga->telepon ?? '-',
                '{{ $pengajuan->nomor_surat }}' => $this->nomor_surat ?? '[BELUM ADA NOMOR]',
                '{{ $tanggal_hari_ini }}' => \Carbon\Carbon::now()->translatedFormat('d F Y'),
                '{{ $kepala_desa }}' => config('settings.kades_nama', '....................'),
                '{{ $nip_kepala_desa }}' => config('settings.kades_nip', '....................'),
            ];
            
            foreach ($isian as $key => $value) {
                if (is_string($value)) {
                    $replaces['{{ $isian[\''.$key.'\'] }}'] = $value;
                }
            }
            $konten = str_replace(array_keys($replaces), array_values($replaces), $this->jenisSurat->template_konten);
        }
        
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class) && view()->exists($viewName)) {
            $pengajuan = $this;
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewName, compact('pengajuan', 'konten'));
            return $pdf->output();
        }
        
        return null;
    }
}
