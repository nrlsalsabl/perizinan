<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPerizinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_jenis_perizinan',
        'masa_berlaku',
        'retribusi',
        'po',
        'bu',
        'sop',
        'status',
        'online',
        'format_no_izin',
        'dinas_badan',
    ];
}
