<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuRegisterSurat extends Model
{
    protected $guarded = ['id'];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}
