<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $fillable = ['pertanyaan_id', 'pilihan_jawaban', 'bobot_nilai'];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}
