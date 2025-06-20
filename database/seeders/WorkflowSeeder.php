<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workflow;

class WorkflowSeeder extends Seeder
{
    public function run()
    {
        Workflow::create([
            'nama_alur' => 'IzinTTD Kadis',
        ]);

        Workflow::create([
            'nama_alur' => 'Izin TTD Gubernur',
        ]);

        Workflow::create([
            'nama_alur' => 'Izin Beretribusi',
        ]);
    }
}
