<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'lokasi_id',
        'tgl_permohonan',
        'nomor_surat',
        'nama',
        'jenis_usaha',
        'jenis_pembangkit',
        'kualifikasi',
        'surat_permohonan',
        'ktp_dir',
        'nib_oss',
        'izin_usaha',
        'akta_per',
        'profil_per',
        'npwp_kaltim',
        'surat_domisili',
        'sertif_badan',
        'rencana_peng',
        'surat_pene',
        'sertif_kompeten',
        'sertif_iso',
        'sop',
        'peralatan_sewa',
        'surat_kuasa',
        'nomor_pertim',
        'tgl_pertim'
    ];

    public function lokasi()
    {
        return $this->belongsTo(lokasiIzin::class)
        ->withDefault();
    }
}
