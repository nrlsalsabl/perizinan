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
        Schema::create('data_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemohon_id')->constrained('data_pemohons')->onDelete('cascade');
            $table->string('nib')->nullable();
            $table->string('npwp')->nullable();
            $table->string('npwd')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('bentuk_perusahaan')->nullable();
            $table->string('status_perusahaan')->nullable();
            $table->string('phone')->nullable();
            $table->string('kode_pos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_perusahaans');
    }
};
