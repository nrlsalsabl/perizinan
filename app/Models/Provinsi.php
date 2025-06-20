<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsis'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['kode', 'nama', 'singkatan']; // Kolom yang dapat diisi
}
