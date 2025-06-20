<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CleanupJenisIzinsTable extends Migration
{
    public function up()
    {
        // Add your cleanup logic here if needed
        DB::table('jenis_izins')
            ->where('nama_jenis_izin', 'IZIN ANGKUTAN DALAM TRAYEK/ANGKUTAN ANTAR KOTA DALAM PROVINSI')
            ->update(['nama_jenis_izin' => 'IZIN ANGKUTAN DALAM TRAYEK/ANGKUTAN ANTAR KOTA DALAM PROVINSI - Updated']);

        DB::table('jenis_izins')
            ->where('nama_jenis_izin', 'IZIN MENDIRIKAN BANGUNAN')
            ->update(['nama_jenis_izin' => 'IZIN MENDIRIKAN BANGUNAN - Updated']);
    }

    public function down()
    {
        // Reverse the updates if necessary
        DB::table('jenis_izins')
            ->where('nama_jenis_izin', 'IZIN ANGKUTAN DALAM TRAYEK/ANGKUTAN ANTAR KOTA DALAM PROVINSI - Updated')
            ->update(['nama_jenis_izin' => 'IZIN ANGKUTAN DALAM TRAYEK/ANGKUTAN ANTAR KOTA DALAM PROVINSI']);

        DB::table('jenis_izins')
            ->where('nama_jenis_izin', 'IZIN MENDIRIKAN BANGUNAN - Updated')
            ->update(['nama_jenis_izin' => 'IZIN MENDIRIKAN BANGUNAN']);
    }
}
