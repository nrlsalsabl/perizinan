<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBentukPerusahaansTable extends Migration
{
    public function up()
    {
        Schema::create('bentuk_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->string('bentuk_perusahaan');
            $table->string('singkatan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bentuk_perusahaans');
    }
}
