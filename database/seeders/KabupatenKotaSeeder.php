<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KabupatenKota;
use Illuminate\Support\Facades\DB;

class KabupatenKotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kabupatenKotas = [
            ['kode' => '6401', 'nama' => 'KABUPATEN PASER', 'singkatan' => '64'],
            ['kode' => '6402', 'nama' => 'KABUPATEN KUTAI BARAT', 'singkatan' => '64'],
            ['kode' => '6403', 'nama' => 'KABUPATEN KUTAI KARTANEGARA', 'singkatan' => '64'],
            ['kode' => '6404', 'nama' => 'KABUPATEN KUTAI TIMUR', 'singkatan' => '64'],
            ['kode' => '6405', 'nama' => 'KABUPATEN BERAU', 'singkatan' => '64'],
            ['kode' => '6409', 'nama' => 'KABUPATEN PENAJAM PASER UTARA', 'singkatan' => '64'],
            ['kode' => '6411', 'nama' => 'KABUPATEN MAHAKAM HULU', 'singkatan' => '64'],
            ['kode' => '6471', 'nama' => 'KOTA BALIKPAPAN', 'singkatan' => '64'],
            ['kode' => '6472', 'nama' => 'KOTA SAMARINDA', 'singkatan' => '64'],
            ['kode' => '6474', 'nama' => 'KOTA BONTANG', 'singkatan' => '64']
        ];

        foreach ($kabupatenKotas as $kabupatenKota) {
            DB::table('kabupaten_kotas')->updateOrInsert(
                ['kode' => $kabupatenKota['kode']],
                $kabupatenKota
            );
        }
    }
}
