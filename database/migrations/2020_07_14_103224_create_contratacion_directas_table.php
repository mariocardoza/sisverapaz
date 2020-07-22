<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratacionDirectasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratacion_directas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->string('numero_proceso')->nullable();
            $table->bigInteger('emergencia_id');
            $table->string('nombre');
            $table->integer('anio');
            $table->double('monto',8,2);
            $table->integer('estado')->default(1);
            $table->bigInteger('user_id')->unsigned();
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
        Schema::dropIfExists('contratacion_directas');
    }
}
