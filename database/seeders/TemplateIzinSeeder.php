<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TemplateIzinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('template_izins')->insert([
            [
                'nama_layanan' => 'Perizinan Baru',
                'template_surat' => 'template_perizinan_baru.docx',
                'template_teknis' => 'template_teknis_perizinan_baru.docx',
                'jenis_izin_id' => 1, // Assuming the 'jenis_izin_id' for the example
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_layanan' => 'Perpanjangan Perijinan',
                'template_surat' => 'template_perpanjangan_perijinan.docx',
                'template_teknis' => 'template_teknis_perpanjangan_perijinan.docx',
                'jenis_izin_id' => 1, // Assuming the 'jenis_izin_id' for the example
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_layanan' => 'Perubahan Perijinan',
                'template_surat' => 'template_perubahan_perijinan.docx',
                'template_teknis' => 'template_teknis_perubahan_perijinan.docx',
                'jenis_izin_id' => 1, // Assuming the 'jenis_izin_id' for the example
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
