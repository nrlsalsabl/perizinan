<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringPerizinanTable extends Migration
{
    public function up()
    {
        Schema::create('monitoring_perizinan', function (Blueprint $table) {
            $table->id();
            $table->string('resi')->unique();
            $table->string('pemohon');
            $table->string('perusahaan')->nullable();
            $table->string('jenis_proses_perizinan');
            $table->enum('status', ['Diajukan', 'Diproses', 'Selesai', 'Ditolak'])->default('Diajukan');
            $table->date('tanggal_pengajuan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monitoring_perizinan');
    }
}
