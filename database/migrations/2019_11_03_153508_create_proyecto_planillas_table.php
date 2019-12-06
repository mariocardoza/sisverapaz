<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectoPlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_planillas', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->bigInteger('proyecto_id')->unsigned();
            $table->string('catorcena_id');
            $table->string('cargo_id');
            $table->bigInteger('empleado_id')->unsigned();
            $table->integer('numero_dias')->unsigned();
            $table->integer('estado')->default(1);
            $table->double('salario_dia',8,2)->unsigned();
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('catorcena_id')->references('id')->on('periodo_proyectos');
            $table->foreign('empleado_id')->references('id')->on('empleados');
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
        Schema::dropIfExists('proyecto_planillas');
    }
}
