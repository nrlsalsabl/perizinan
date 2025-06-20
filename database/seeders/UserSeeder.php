<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "username" => "Super Admin",
                "name" => "Super Admin",
                "email" => "admin@gmail.com", 
                "password" => bcrypt("12345678"),
                "nip" => "11223344",
                "jabatan" => "admin",
                "phone" => "088576455882",
                "remember_token" => Str::random(10),
            ],
            [
                "username" => "Front Office",
                "name" => "Front Office",
                "email" => "front@gmail.com",
                "password" => bcrypt("12345678"),
                "nip" => "22334455",
                "jabatan" => "front_office",
                "phone" => "088576455883",
                "remember_token" => Str::random(10),
            ],
            [
                "username" => "Kasi",
                "name" => "Kepala Seksi",
                "email" => "kasi@gmail.com",
                "password" => bcrypt("12345678"), 
                "nip" => "33445566",
                "jabatan" => "kasi",
                "phone" => "088576455884",
                "remember_token" => Str::random(10),
            ],
            [
                "username" => "Back Office",
                "name" => "Back Office",
                "email" => "back@gmail.com",
                "password" => bcrypt("12345678"),
                "nip" => "44556677",
                "jabatan" => "back_office", 
                "phone" => "088576455885",
                "remember_token" => Str::random(10),
            ],
            [
                "username" => "User",
                "name" => "Regular User",
                "email" => "user@gmail.com",
                "password" => bcrypt("12345678"),
                "nip" => "55667788",
                "jabatan" => "user",
                "phone" => "088576455886",
                "remember_token" => Str::random(10),
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['username' => $user['username']],
                $user
            );
        }
    }
}
