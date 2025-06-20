<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisLayanan;

class JenisLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenisLayanan = [
            [
                'kode_jenis_layanan' => 'JL001',
                'nama_jenis_layanan' => 'Layanan A',
                'alias' => 'A'
            ],
            [
                'kode_jenis_layanan' => 'JL002',
                'nama_jenis_layanan' => 'Layanan B',
                'alias' => 'B'
            ],
            [
                'kode_jenis_layanan' => 'JL003',
                'nama_jenis_layanan' => 'Layanan C',
                'alias' => 'C'
            ],
        ];

        foreach ($jenisLayanan as $layanan) {
            JenisLayanan::create($layanan);
        }
    }
}
