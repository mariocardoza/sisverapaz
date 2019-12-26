<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_pagos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->bigInteger('servicio_id')->unsigned();
            $table->bigInteger('cuenta_id')->unsigned();
            $table->double('monto',8,2);
            $table->date('fecha_pago');
            $table->integer('estado')->default(1);
            $table->integer('anio');
            $table->string('mes');
            $table->string('archivo')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
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
        Schema::dropIfExists('servicios_pagos');
    }
}
