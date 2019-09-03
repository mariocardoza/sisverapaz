<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicadoresProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadores_proyectos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nombre');
            $table->float('porcentaje',8,2);
            $table->string('descripcion')->nullable();
            $table->integer('estado')->default(1);
            $table->bigInteger('proyectos_id')->unsigned();
            $table->foreign('proyectos_id')->references('id')->on('proyectos');
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
        Schema::dropIfExists('indicadores_proyectos');
    }
}
