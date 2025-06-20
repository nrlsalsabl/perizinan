<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertanyaansTable extends Migration
{
    public function up()
    {
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id();
            $table->string('pertanyaan');
            $table->boolean('status')->default(true); // Pertanyaan aktif atau tidak
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pertanyaans');
    }
}
