<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelReferensi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_tabel'];

    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }
}
