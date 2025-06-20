<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanIzin extends Model
{
    use HasFactory;

    protected $table = 'permohonan_izins';

    protected $fillable = [
        'resi',
        'nama_pemohon',
        'jenis_izin_id',
        'jenis_proses_perizinan',
        'proses_terakhir',
        'role',
        'catatan',
    ];

    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class, 'jenis_izin_id');
    }
}
