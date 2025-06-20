<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPersyaratan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_persyaratan',
        'nama_nomor',
    ];
}
