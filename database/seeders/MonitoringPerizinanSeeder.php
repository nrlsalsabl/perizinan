<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonitoringPerizinanSeeder extends Seeder
{
    public function run()
    {
        DB::table('monitoring_perizinan')->insert([
            [
                'resi' => 'RESI123456',
                'pemohon' => 'John Doe',
                'perusahaan' => 'PT. ABC',
                'jenis_proses_perizinan' => 'Izin Mendirikan Bangunan',
                'status' => 'Diajukan',
                'tanggal_pengajuan' => Carbon::now()->subDays(5),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'resi' => 'RESI654321',
                'pemohon' => 'Jane Smith',
                'perusahaan' => 'CV. XYZ',
                'jenis_proses_perizinan' => 'Izin Usaha Perdagangan',
                'status' => 'Diproses',
                'tanggal_pengajuan' => Carbon::now()->subDays(3),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'resi' => 'RESI789012',
                'pemohon' => 'Alice Johnson',
                'perusahaan' => 'PT. DEF',
                'jenis_proses_perizinan' => 'Izin Lingkungan',
                'status' => 'Selesai',
                'tanggal_pengajuan' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
