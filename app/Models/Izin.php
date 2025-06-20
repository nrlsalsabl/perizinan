<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'Izin'; // Pastikan nama tabel sesuai dengan yang ada di database

    // Definisikan kolom yang ada di tabel
    protected $fillable = [
        'resi',
        'pemohon',
        'perusahaan',
        'jenis_izin',
        'tanggal',
        'status',
    ];
}
