<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisIzin extends Model
{
    use HasFactory;

    protected $table = 'jenis_izins'; // Nama tabel sesuai dengan gambar

    protected $fillable = [
        'nama_jenis_izin',
    ];

    // Relasi dengan RekapitulasiIzin
    public function rekapitulasiIzins()
    {
        return $this->hasMany(RekapitulasiIzin::class, 'jenis_izin_id');
    }

    // Relasi dengan IzinTerbit
    public function izinTerbits()
    {
        return $this->hasMany(IzinTerbit::class, 'jenis_izin_id');
    }

    public function permohonanIzins()
    {
        return $this->hasMany(PermohonanIzin::class, 'jenis_izin_id');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'jenis_izin_id');
    }
}
