<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengajuanPermohonan extends Model
{
    use HasFactory;

    protected $fillable = ['dinas_badan', 'jenis_izin', 'jenis_permohonan'];

    // Relasi ke PostNewsDetail
    public function pemohon()
    {
        return $this->hasMany(dataPemohon::class);
    }
}
