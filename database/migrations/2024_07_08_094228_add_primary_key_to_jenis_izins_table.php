<?php

// database/migrations/xxxx_xx_xx_add_primary_key_to_jenis_izins_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrimaryKeyToJenisIzinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_izins', function (Blueprint $table) {
            if (!Schema::hasColumn('jenis_izins', 'id')) {
                $table->id(); // Add the primary key column if it doesn't exist
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_izins', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}

