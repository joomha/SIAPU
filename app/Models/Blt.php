<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blt extends Model
{
    protected $guarded = ['id'];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
