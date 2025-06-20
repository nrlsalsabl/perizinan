<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\PermitNumberGenerator;

class IzinTerbit extends Model
{
    use HasFactory;

    protected $table = 'izin_terbits'; // Nama tabel

    protected $fillable = [
        'resi_nama_pemohon',
        'perusahaan',
        'lokasi_izin',
        'jenis_izin_id',
        'tanggal_terbit',
        'berlaku_sampai',
        'no_izin',
        'dokumen_izin',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_izin)) {
                $model->no_izin = PermitNumberGenerator::generate($model->jenis_izin_id);
            }
        });
    }

    // Relasi dengan JenisIzin
    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class, 'jenis_izin_id');
    }
}
