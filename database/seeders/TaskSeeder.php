<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Workflow;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $workflow = Workflow::where('nama_alur', 'IzinTTD Kadis')->first();
        Task::create([
            'workflow_id' => $workflow->id,
            'taskname' => 'Task 1',
            'status' => 'Pending',
        ]);

        $workflow = Workflow::where('nama_alur', 'Izin TTD Gubernur')->first();
        Task::create([
            'workflow_id' => $workflow->id,
            'taskname' => 'Task 2',
            'status' => 'Completed',
        ]);

        $workflow = Workflow::where('nama_alur', 'Izin Beretribusi')->first();
        Task::create([
            'workflow_id' => $workflow->id,
            'taskname' => 'Task 3',
            'status' => 'In Progress',
        ]);
    }
}
