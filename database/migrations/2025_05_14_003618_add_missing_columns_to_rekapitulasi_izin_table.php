<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('rekapitulasi_izin', function (Blueprint $table) {
        // Add missing columns
        $table->string('nama_pemohon')->nullable(); // Adjust data type as needed
        $table->unsignedBigInteger('jenis_izin_id')->nullable();
        // Only add tanggal_pengajuan if it does not exist
        if (!Schema::hasColumn('rekapitulasi_izin', 'tanggal_pengajuan')) {
            $table->date('tanggal_pengajuan')->nullable();
        }

        // Add foreign key (if needed)
        $table->foreign('jenis_izin_id')->references('id')->on('jenis_izins');
    });
}

public function down()
{
    Schema::table('rekapitulasi_izin', function (Blueprint $table) {
        $table->dropForeign(['jenis_izin_id']);
        $table->dropColumn(['nama_pemohon', 'jenis_izin_id', 'tanggal_pengajuan']);
    });
}
};
