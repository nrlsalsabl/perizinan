<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelolaDataKadisSeeder extends Seeder
{
    public function run()
    {
        DB::table('kelola_data_kadis')->insert([
            ['nip' => '123456789', 'nama' => 'John Doe', 'pangkat' => 'IV/a', 'periode' => '2020-2024', 'status' => 'Active', 'ttd' => 'path/to/signature1.png'],
            ['nip' => '987654321', 'nama' => 'Jane Smith', 'pangkat' => 'IV/b', 'periode' => '2018-2022', 'status' => 'Inactive', 'ttd' => 'path/to/signature2.png'],
            // Add more entries as needed
        ]);
    }
}
