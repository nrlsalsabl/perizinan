<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['tabel_referensi_id', 'nama_kategori'];

    public function tabelReferensi()
    {
        return $this->belongsTo(TabelReferensi::class);
    }
}
