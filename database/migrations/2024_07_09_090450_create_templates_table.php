<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_izin_id');
            $table->string('nama_layanan');
            $table->string('template_surat')->nullable();
            $table->string('template_teknis')->nullable();
            $table->timestamps();

            $table->foreign('jenis_izin_id')->references('id')->on('jenis_izins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('templates');
    }
}

