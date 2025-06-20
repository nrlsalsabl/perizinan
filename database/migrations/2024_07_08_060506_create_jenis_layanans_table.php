<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisLayanansTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_layanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jenis_layanan')->unique();
            $table->string('nama_jenis_layanan');
            $table->string('alias')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_layanans');
    }
}
