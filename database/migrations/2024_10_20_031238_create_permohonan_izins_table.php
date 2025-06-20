<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermohonanIzinsTable extends Migration
{
    public function up()
    {
        Schema::create('permohonan_izins', function (Blueprint $table) {
            $table->id();
            $table->string('resi');
            $table->string('nama_pemohon');
            $table->unsignedBigInteger('jenis_izin_id');
            $table->string('jenis_proses_perizinan');
            $table->string('proses_terakhir');
            $table->string('role');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('jenis_izin_id')->references('id')->on('jenis_izins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_izins');
    }
}
