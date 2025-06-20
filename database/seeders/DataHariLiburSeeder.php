<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataHariLiburSeeder extends Seeder
{
    public function run()
    {
        $holidays = [
            // Tahun Baru 2025
            ['tanggal_libur' => '2025-01-01', 'deskripsi' => 'Tahun Baru 2025'],
            
            // Hari Raya Idul Fitri 1446 H (perkiraan)
            ['tanggal_libur' => '2025-03-30', 'deskripsi' => 'Hari Raya Idul Fitri 1446 H'],
            ['tanggal_libur' => '2025-03-31', 'deskripsi' => 'Hari Raya Idul Fitri 1446 H'],
            
            // Hari Buruh Internasional
            ['tanggal_libur' => '2025-05-01', 'deskripsi' => 'Hari Buruh Internasional'],
            
            // Hari Raya Waisak
            ['tanggal_libur' => '2025-05-13', 'deskripsi' => 'Hari Raya Waisak'],
            
            // Kenaikan Isa Almasih
            ['tanggal_libur' => '2025-05-22', 'deskripsi' => 'Kenaikan Isa Almasih'],
            
            // Hari Raya Idul Adha 1446 H (perkiraan)
            ['tanggal_libur' => '2025-06-07', 'deskripsi' => 'Hari Raya Idul Adha 1446 H'],
            
            // Tahun Baru Islam 1447 H (perkiraan)
            ['tanggal_libur' => '2025-06-27', 'deskripsi' => 'Tahun Baru Islam 1447 H'],
            
            // Hari Kemerdekaan RI
            ['tanggal_libur' => '2025-08-17', 'deskripsi' => 'Hari Kemerdekaan RI'],
            
            // Maulid Nabi Muhammad SAW 1447 H (perkiraan)
            ['tanggal_libur' => '2025-09-05', 'deskripsi' => 'Maulid Nabi Muhammad SAW 1447 H'],
            
            // Hari Natal
            ['tanggal_libur' => '2025-12-25', 'deskripsi' => 'Hari Natal'],
        ];

        // Insert all holidays
        foreach ($holidays as $holiday) {
            DB::table('data_hari_liburs')->updateOrInsert(
                ['tanggal_libur' => $holiday['tanggal_libur']],
                $holiday
            );
        }
    }
}
