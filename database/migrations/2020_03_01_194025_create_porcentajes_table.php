<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorcentajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('porcentajes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->double('porcentaje',8,2);
            $table->tinyInteger('estado')->default(1);
            $table->string('nombre_simple')->nullable();
            $table->char('tipo')->nullable();
            $table->tinyInteger('es_servicio')->default(0);
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
        Schema::dropIfExists('porcentajes');
    }
}
