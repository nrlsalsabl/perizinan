<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisPersyaratanSeeder extends Seeder
{
    public function run()
    {
        $seedData = [
            [
                'nama_persyaratan' => 'Surat Keterangan Usaha',
                'nama_nomor' => 'SKU',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_persyaratan' => 'Surat Izin Tempat Usaha',
                'nama_nomor' => 'SITU',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_persyaratan' => 'Surat Izin Usaha Perdagangan',
                'nama_nomor' => 'SIUP',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_persyaratan' => 'Tanda Daftar Perusahaan',
                'nama_nomor' => 'TDP',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_persyaratan' => 'Nomor Pokok Wajib Pajak',
                'nama_nomor' => 'NPWP',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_persyaratan' => 'Surat Keterangan Domisili',
                'nama_nomor' => 'SKD',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_persyaratan' => 'Akta Pendirian Perusahaan',
                'nama_nomor' => 'AKTA',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_persyaratan' => 'Laporan Keuangan',
                'nama_nomor' => 'LK',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('jenis_persyaratans')->insert($seedData);
    }
}
