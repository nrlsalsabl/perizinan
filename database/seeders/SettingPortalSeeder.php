<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettingPortal;

class SettingPortalSeeder extends Seeder
{
    public function run()
    {
        $settingPortals = [
            ['nama_file' => 'image1.jpg', 'file_path' => 'uploads/setting_portal/image1.jpg', 'status' => 'active'],
            ['nama_file' => 'image2.jpg', 'file_path' => 'uploads/setting_portal/image2.jpg', 'status' => 'inactive'],
        ];

        foreach ($settingPortals as $setting) {
            SettingPortal::create($setting);
        }
    }
}

