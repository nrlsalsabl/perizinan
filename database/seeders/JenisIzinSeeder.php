<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisIzinSeeder extends Seeder
{
    public function run()
    {
        $jenisIzins = [
            ['nama_jenis_izin' => 'Izin Keamanan PSA / Health Certificate'],
            ['nama_jenis_izin' => 'Izin Konstruksi Pada Sumber Daya Air Pada Wilayah Kewenangan Provinsi'],
            ['nama_jenis_izin' => 'Izin Lokasi Lintas Kabupaten / Kota'],
            ['nama_jenis_izin' => 'Izin Merger'],
            ['nama_jenis_izin' => 'IZIN OPERASIONAL PEMBENTUKAN KANTOR CABANG PELAKSANA PENEMPATAN TENAGA KERJA INDONESIA SWASTA (PPTKIS)'],
            ['nama_jenis_izin' => 'IZIN OPERASIONAL PERUSAHAAN PENYEDIA JASA PEKERJA / BURUH'],
            ['nama_jenis_izin' => 'Izin Penambahan dan Perubahan Program Keahlian Pada SMK Negeri'],
            ['nama_jenis_izin' => 'Izin Penambahan dan Perubahan Program Keahlian Pada SMK Swasta'],
            ['nama_jenis_izin' => 'Izin Pendirian SLB Negeri'],
            ['nama_jenis_izin' => 'Izin Pendirian SLB Swasta']
        ];

        foreach ($jenisIzins as $jenisIzin) {
            DB::table('jenis_izins')->updateOrInsert(
                ['nama_jenis_izin' => $jenisIzin['nama_jenis_izin']],
                $jenisIzin
            );
        }
    }
}
