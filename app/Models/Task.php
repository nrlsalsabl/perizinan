<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'taskname',
        'status',
    ];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }
}
