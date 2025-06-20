<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat permissions
        $permissions = [
            "home",
            "users",
            "roles",
            "daftarperizinan",
            "jenislayanan",
            "jenislayananterhadapizin",
            "jenispersyaratan",
            "workflow",
            "templateizin",
            "templateresi",
            "informasiperizinan",
            "settingportal",
            "provinsi",
            "kabkot",
            "kecamatan",
            "dataharilibur",
            "bentukperusahaan",
            "keloladatakadis",
            "datakbli",
            "tabelrefrensi",
            "masternotifikasi",
            "outbox",
            "dashboard",
            "rekapitulasiizin",
            "monitoringperzinan",
            "dataarsip",
            "monitoringizin",
            "izinterbit",
            "releasepermohonan",
            "querybuilder",
            "hasilsurvey",
            "daftarpertanyaan",
            "verifikasipendaftaran",
            "penyerahanizin",
            "verifikasikasi",
            "validasikasi",
            "prosesperizinan",
            "validasikadis",
            "ttdizin"
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat role dan assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        $gubernurRole = Role::firstOrCreate(['name' => 'gubernur']);
        $gubernurRole->givePermissionTo(['home', 'prosesperizinan', 'dashboard', 'monitoringizin']);
    }
}
