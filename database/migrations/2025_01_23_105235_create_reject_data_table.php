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
        Schema::create('reject_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_permohonans')->onDelete('cascade');
            $table->foreignId('detail_id')->constrained('data_details')->onDelete('cascade');
            $table->string('nama_file')->nullable();
            $table->string('validasi')->nullable();
            $table->string('catatan_file')->nullable();
            $table->string('catatan_umum')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reject_data');
    }
};
