<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKBLI extends Model
{
    use HasFactory;

    protected $table = 'data_kblis';

    protected $fillable = [
        'kode_kbli',
        'nama_kbli',
    ];
}
