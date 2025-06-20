<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InformasiPerizinan;

class InformasiPerizinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $informasiPerizinans = [
            ['jenis_izin' => 'Izin Usaha', 'informasi_izin' => 'Informasi mengenai izin usaha.'],
            ['jenis_izin' => 'Izin Mendirikan Bangunan', 'informasi_izin' => 'Informasi mengenai izin mendirikan bangunan.'],
            ['jenis_izin' => 'Izin Lingkungan', 'informasi_izin' => 'Informasi mengenai izin lingkungan.'],
            // Add more entries as needed
        ];

        foreach ($informasiPerizinans as $informasi) {
            InformasiPerizinan::create($informasi);
        }
    }
}

