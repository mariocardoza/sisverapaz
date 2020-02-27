<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicitacionBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licitacion_bases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("archivo");
            $table->integer('estado')->default(1);
            $table->bigInteger('proyecto_id')->unsigned();
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licitacion_bases');
    }
}
