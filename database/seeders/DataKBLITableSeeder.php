<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataKBLI;

class DataKBLITableSeeder extends Seeder
{
    public function run()
    {
        $dataKBLIs = [
            ['kode_kbli' => '01111', 'nama_kbli' => 'Pertanian Jagung'],
            ['kode_kbli' => '01112', 'nama_kbli' => 'Pertanian Gandum'],
            ['kode_kbli' => '01113', 'nama_kbli' => 'Pertanian Padi'],
            ['kode_kbli' => '01114', 'nama_kbli' => 'Pertanian Kedelai'],
            ['kode_kbli' => '01115', 'nama_kbli' => 'Pertanian Kacang Tanah'],
            ['kode_kbli' => '01116', 'nama_kbli' => 'Pertanian Umbi-Umbian'],
            ['kode_kbli' => '01117', 'nama_kbli' => 'Pertanian Sayur-Sayuran'],
            ['kode_kbli' => '01118', 'nama_kbli' => 'Pertanian Buah-Buahan'],
            ['kode_kbli' => '01119', 'nama_kbli' => 'Pertanian Tanaman Lainnya'],
            // Add more entries as needed
        ];

        foreach ($dataKBLIs as $data) {
            DataKBLI::create($data);
        }
    }
}
