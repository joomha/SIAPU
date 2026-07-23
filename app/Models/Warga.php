<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $guarded = ['id'];


    public function surats()
    {
        return $this->hasMany(Surat::class);
    }

    public function pengajuanSurats()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function blts()
    {
        return $this->hasMany(Blt::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
