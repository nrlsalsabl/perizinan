<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_alur',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
