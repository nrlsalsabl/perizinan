<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaftarPerizinansTable extends Migration
{
    public function up()
    {
        Schema::create('daftar_perizinans', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama_jenis_perizinan');
            $table->string('masa_berlaku');
            $table->string('retribusi');
            $table->string('po');
            $table->string('bu');
            $table->string('sop');
            $table->string('status');
            $table->boolean('online');
            $table->string('format_no_izin');
            $table->string('dinas_badan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daftar_perizinans');
    }
}
