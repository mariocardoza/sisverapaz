<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditContratoProyectos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('contratacion_proyectos');
        Schema::dropIfExists('contrato_proyectos');
        Schema::create('contrato_proyectos', function (Blueprint $table) {
            $table->string('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('archivo');
            $table->bigInteger('proyecto_id')->unsigned();
            $table->timestamps();
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contrato_proyectos');
    }
}
