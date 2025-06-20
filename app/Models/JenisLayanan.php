<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_jenis_layanan', 
        'nama_jenis_layanan', 
        'alias'
    ];
}
