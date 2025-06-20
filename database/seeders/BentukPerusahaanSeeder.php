<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BentukPerusahaanSeeder extends Seeder
{
    public function run()
    {
        DB::table('bentuk_perusahaans')->insert([
            ['bentuk_perusahaan' => 'Perseroan Terbatas', 'singkatan' => 'PT'],
            ['bentuk_perusahaan' => 'Komanditer', 'singkatan' => 'CV'],
            ['bentuk_perusahaan' => 'Firma', 'singkatan' => 'FA'],
            ['bentuk_perusahaan' => 'Perusahaan Daerah', 'singkatan' => 'PD'],
            ['bentuk_perusahaan' => 'Usaha Dagang', 'singkatan' => 'UD'],
            // Add more entries as needed
        ]);
    }
}
