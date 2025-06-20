<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataPemohon extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'nik',
        'name',
        'alamat',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'phone',
        'kode_pos',
        'email'
    ];

    public function pengajuan()
    {
        return $this->hasOne(dataPerusahaan::class, 'pemohon_id', 'id');
    }

    public function perusahaan()
    {
        return $this->hasOne(lokasiIzin::class, 'perusahaan_id', 'id');
    }
}
