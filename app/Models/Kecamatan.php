<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatans'; // Sesuaikan dengan nama tabel di database
    protected $fillable = [
        'kode',
        'nama',
        'kabupaten_kota',
        'provinsi',
    ];

    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
