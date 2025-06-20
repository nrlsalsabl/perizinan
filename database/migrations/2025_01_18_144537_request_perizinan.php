<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request_perizinan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_permohonans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('resi')->nullable();
            $table->string('nama_pemohon')->nullable();
            $table->string('jenis_izin')->nullable();
            $table->string('jenis_permohonan')->nullable();
            $table->string('proses_terakhir')->nullable();
            $table->string('role')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // $table->foreign('jenis_izin_id')->references('id')->on('jenis_izins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_perizinan');
    }
};
