<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapitulasiIzin extends Model
{
    use HasFactory;

    protected $table = 'rekapitulasi_izin'; // Nama tabel sesuai dengan gambar

    protected $fillable = [
        'nama_pemohon',
        'jenis_izin_id',
        'tanggal_pengajuan',
        'status',
        'created_at',
        'updated_at',
    ];

    // Relasi dengan JenisIzin
    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class, 'jenis_izin_id');
    }
}
