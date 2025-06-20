<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataArsip;

class DataArsipSeeder extends Seeder
{
    public function run()
    {
        DataArsip::create([
            'account' => '1',
            'nik_npwp' => '6471040108880002',
            'nama_pemohon' => 'Aas Gususanto',
            'alamat' => 'Wisma KIE Lantai 2Jl Ammonia Kav 79',
            'nama_perusahaan' => 'Perusahaan A',
            'alamat_perusahaan' => 'Alamat Perusahaan A',
            'izin' => 2,
            'arsip' => 12
        ]);

        // Tambahkan data lainnya jika diperlukan
    }
}
