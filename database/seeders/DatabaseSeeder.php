<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisIzin;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\TemplateIzin;
use App\Models\TemplateResi;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\JenisIzinSeeder;
use Database\Seeders\ProvinsiSeeder;
use Database\Seeders\KabupatenKotaSeeder;
use Database\Seeders\KecamatanSeeder;
use Database\Seeders\BentukPerusahaanSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // NotifikasiSeeder::class,
            // OutboxSeeder::class,
            UserSeeder::class,
            RolePermissionSeeder::class,
            JenisIzinSeeder::class,
            ProvinsiSeeder::class,
            KabupatenKotaSeeder::class,
            KecamatanSeeder::class,
            BentukPerusahaanSeeder::class,

        ]);
    }
}
