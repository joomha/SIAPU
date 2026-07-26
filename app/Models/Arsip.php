<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $guarded = ['id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }

    public function pengajuan_surat()
    {
        return $this->belongsTo(PengajuanSurat::class);
    }

    public function getNomorSuratAttribute()
    {
        return $this->surat ? $this->surat->nomor_surat : ($this->pengajuan_surat ? $this->pengajuan_surat->nomor_surat : '-');
    }

    public function getWargaAttribute()
    {
        return $this->surat ? $this->surat->warga : ($this->pengajuan_surat ? $this->pengajuan_surat->warga : null);
    }
}
