<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekapitulasiIzinSeeder extends Seeder
{
    public function run()
    {
        // Sample data for rekapitulasi_izin table
        $data = [
            [
                'nama_pemohon' => 'John Doe',
                'jenis_izin_id' => 1,
                'tanggal_pengajuan' => Carbon::now()->subDays(10)->toDateString(),
                'status' => 'Approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_pemohon' => 'Jane Smith',
                'jenis_izin_id' => 2,
                'tanggal_pengajuan' => Carbon::now()->subDays(5)->toDateString(),
                'status' => 'Pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more sample data as needed
        ];

        // Insert the data into the rekapitulasi_izin table
        DB::table('rekapitulasi_izins')->insert($data);
    }
}
