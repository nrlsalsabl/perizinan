<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataArsipTable extends Migration
{
    public function up()
    {
        Schema::create('data_arsip', function (Blueprint $table) {
            $table->id();
            $table->string('account');
            $table->string('nik_npwp');
            $table->string('nama_pemohon');
            $table->string('alamat');
            $table->string('nama_perusahaan')->nullable();
            $table->string('alamat_perusahaan')->nullable();
            $table->integer('izin')->default(0);
            $table->integer('arsip')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_arsip');
    }
}
