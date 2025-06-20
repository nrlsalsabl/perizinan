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
        Schema::create('data_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_id')->constrained('lokasi_izins')->onDelete('cascade');
            $table->string('tgl_permohonan')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->string('nama')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->string('jenis_pembangkit')->nullable();
            $table->string('kualifikasi')->nullable();
            $table->string('surat_permohonan')->nullable();
            $table->string('ktp_dir')->nullable();
            $table->string('nib_oss')->nullable();
            $table->string('izin_usaha')->nullable();
            $table->string('akta_per')->nullable();
            $table->string('profil_per')->nullable();
            $table->string('npwp_kaltim')->nullable();
            $table->string('surat_domisili')->nullable();
            $table->string('sertif_badan')->nullable();
            $table->string('rencana_peng')->nullable();
            $table->string('surat_pene')->nullable();
            $table->string('sertif_kompeten')->nullable();
            $table->string('sertif_iso')->nullable();
            $table->string('sop')->nullable();
            $table->string('peralatan_sewa')->nullable();
            $table->string('surat_kuasa')->nullable();
            $table->string('nomor_pertim')->nullable();
            $table->string('tgl_pertim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_details');
    }
};
