<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TabelReferensi;

class TabelReferensiSeeder extends Seeder
{
    public function run()
    {
        // Add your seed data here
        TabelReferensi::create([
            'nama_tabel' => 'Example Tabel 1',
        ]);
        // Add more seed data as needed
    }
}
