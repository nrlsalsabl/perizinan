<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rejectData extends Model
{
    use HasFactory;

    protected $table = 'reject_data'; // Sesuaikan dengan nama tabel di database
    protected $fillable = [
        'pengajuan_id', 
        'detail_id', 
        'nama_file', 
        'validasi', 
        'catatan_file', 
        'catatan_umum', 
    ]; 
}
