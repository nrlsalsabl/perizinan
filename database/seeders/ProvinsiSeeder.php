<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Provinsi;

class ProvinsiSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::table('provinsis')->truncate();
        
        $provinces = [
            ['kode' => '64', 'nama' => 'KALIMANTAN TIMUR'],
        ];

        DB::table('provinsis')->insert($provinces);
    }
}
