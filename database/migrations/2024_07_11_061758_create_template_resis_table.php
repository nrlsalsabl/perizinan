<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateResisTable extends Migration
{
    public function up()
    {
        Schema::create('template_resis', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('template_resis');
    }
}
