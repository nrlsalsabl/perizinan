<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BentukPerusahaan extends Model
{
    use HasFactory;

    protected $fillable = ['bentuk_perusahaan', 'singkatan'];
}
