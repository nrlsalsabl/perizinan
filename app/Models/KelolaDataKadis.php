<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelolaDataKadis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip', 'nama', 'pangkat', 'periode', 'status', 'ttd',
    ];
}
