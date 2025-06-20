<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifikasi;

class NotifikasiSeeder extends Seeder
{
    public function run()
    {
        Notifikasi::create(['judul' => 'Notification 1', 'pesan' => 'This is the first notification message.']);
        Notifikasi::create(['judul' => 'Notification 2', 'pesan' => 'This is the second notification message.']);
        // Add more seed data as needed
    }
}
