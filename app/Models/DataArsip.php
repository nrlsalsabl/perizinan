<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataArsip extends Model
{
    use HasFactory;

    protected $table = 'data_arsip';

    protected $fillable = [
        'account',
        'nik_npwp',
        'nama_pemohon',
        'alamat',
        'nama_perusahaan',
        'alamat_perusahaan',
        'izin',
        'arsip',
    ];
}
