<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinTerbitsTable extends Migration
{
    public function up()
    {
        Schema::create('izin_terbits', function (Blueprint $table) {
            $table->id();
            $table->string('resi_nama_pemohon');
            $table->string('perusahaan');
            $table->string('lokasi_izin');
            $table->unsignedBigInteger('jenis_izin_id');
            $table->date('tanggal_terbit');
            $table->date('berlaku_sampai');
            $table->string('no_izin');
            $table->string('dokumen_izin')->nullable();
            $table->timestamps();

            $table->foreign('jenis_izin_id')->references('id')->on('jenis_izins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('izin_terbits');
    }
}
