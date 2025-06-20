<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingPortal extends Model
{
    use HasFactory;

    protected $fillable = ['nama_file', 'file_path', 'status'];
}

