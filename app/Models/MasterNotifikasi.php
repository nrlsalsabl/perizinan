<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterNotifikasi extends Model
{
    use HasFactory;

    protected $table = 'master_notifikasis';

    protected $fillable = [
        'category',
        'text_sms',
        'text_email',
        'subject_email',
    ];
}


