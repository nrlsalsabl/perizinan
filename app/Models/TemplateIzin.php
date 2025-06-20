<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateIzin extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_izin_id', 'nama_layanan', 'template_surat', 'template_teknis'];

    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class, 'jenis_izin_id');
    }
}
