<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataPerusahaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemohon_id',
        'nib',
        'npwp',
        'npwd',
        'nama_perusahaan',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'bentuk_perusahaan',
        'status_perusahaan',
        'phone',
        'kode_pos',
    ];

    public function pemohon()
    {
        return $this->belongsTo(dataPemohon::class);
    }

    public function lokasi()
    {
        return $this->hasMany(lokasiIzin::class);
    }
}
