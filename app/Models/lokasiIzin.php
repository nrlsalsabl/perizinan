<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lokasiIzin extends Model
{
    use HasFactory;

    protected $fillable = [
        'perusahaan_id',
        'jalan',
        'rt',
        'rw',
        'nomor',
        'provinsi',
        'kabupaten',
        'kecamatan',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(dataPerusahaan::class);
    }

    public function detail()
    {
        return $this->hasMany(dataDetail::class);
    }
}
