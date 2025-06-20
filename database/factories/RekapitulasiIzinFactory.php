<?php

namespace Database\Factories;

use App\Models\RekapitulasiIzin;
use Illuminate\Database\Eloquent\Factories\Factory;

class RekapitulasiIzinFactory extends Factory
{
    protected $model = RekapitulasiIzin::class;

    public function definition()
    {
        return [
            'nama_pemohon' => $this->faker->name,
            'jenis_izin_id' => \App\Models\JenisIzin::factory(), // Make sure you have a factory for JenisIzin
            'tanggal_pengajuan' => $this->faker->date,
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
        ];
    }
}

