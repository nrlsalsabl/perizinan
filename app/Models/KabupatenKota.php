<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabupatenKota extends Model
{
    use HasFactory;

    protected $table = 'kabupaten_kotas'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['kode', 'nama', 'singkatan']; // Kolom yang dapat diisi
}
