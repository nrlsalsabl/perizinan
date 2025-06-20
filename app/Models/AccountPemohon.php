<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPemohon extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'alamat',
        'telepon',
        'last_login',
        'npwp',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'kode_pos',
        'email',
        'password',

    ];
}
