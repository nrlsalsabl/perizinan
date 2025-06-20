<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKblisTable extends Migration
{
    public function up()
    {
        Schema::create('data_kblis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kbli')->unique();
            $table->string('nama_kbli');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_kblis');
    }
}
