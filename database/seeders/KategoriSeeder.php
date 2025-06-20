<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        // Add your seed data here
        Kategori::create([
            'tabel_referensi_id' => 1,
            'nama_kategori' => 'Example Kategori 1',
        ]);
        // Add more seed data as needed
    }
}
