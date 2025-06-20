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
        $table->date('tanggal_pengajuan')->nullable(); // Or use ->after('column_name') to position it
    });
}

public function down()
{
    Schema::table('rekapitulasi_izin', function (Blueprint $table) {
        $table->dropColumn('tanggal_pengajuan');
    });
}
};
