<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasiIzinsTable extends Migration
{
    public function up()
    {
        Schema::create('rekapitulasi_izin', function (Blueprint $table) {
            $table->id();
            $table->string('resi');
            $table->string('pemohon');
            $table->string('perusahaan');
            $table->string('jenis_proses_perizinan');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekapitulasi_izin');
    }
}
