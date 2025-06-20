<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'text_sms',
        'text_email',
        'subject_email',
    ];
}
