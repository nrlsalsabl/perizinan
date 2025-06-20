<?php

// database/migrations/xxxx_xx_xx_create_jenis_izins_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisIzinsTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_izins', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis_izin')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_izins');
    }
}

