<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'request_perizinan'; // Sesuaikan dengan nama tabel di database
    protected $fillable = [
        'pengajuan_id', 
        'user_id', 
        'resi', 
        'nama_pemohon', 
        'jenis_izin', 
        'jenis_permohonan', 
        'proses_terakhir', 
        'role', 
        'catatan',
        'verification_status',
        'verified_by',
        'verified_at'
    ]; // Kolom yang dapat diisi

    public function request()
    {
        return $this->belongsTo(User::class);
    }
    
}
