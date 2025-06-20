<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('responden');
            $table->unsignedBigInteger('jenis_izin_id');
            $table->integer('nilai_kepuasan');
            $table->date('tanggal_survey');
            $table->timestamps();

            $table->foreign('jenis_izin_id')->references('id')->on('jenis_izins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
