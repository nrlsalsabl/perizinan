<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DaftarPerizinan;

class DaftarPerizinanSeeder extends Seeder
{
    public function run()
    {
        DaftarPerizinan::create([
            'kode' => 'DP001',
            'nama_jenis_perizinan' => 'Perizinan A',
            'masa_berlaku' => '2025-12-31',
            'retribusi' => '50000',
            'po' => 'PO123',
            'bu' => 'BU123',
            'sop' => 'SOP123',
            'status' => 'Aktif',
            'online' => true,
            'format_no_izin' => 'FNI123',
            'dinas_badan' => 'Dinas A'
        ]);

        // Add more records as needed
    }
}
