<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $guarded = ['id'];



    protected function casts(): array
    {
        return [
            'form_isian' => 'array',
            'persyaratan_dokumen' => 'array',
        ];
    }

    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function pengajuanSurats()
    {
        return $this->hasMany(PengajuanSurat::class);
    }
}
