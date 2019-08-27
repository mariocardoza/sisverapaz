<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_detalles', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->bigInteger('cuenta_id')->unsigned();
            $table->string('accion');
            $table->integer('tipo'); /// 1 ingreso, 2 egreso
            $table->double('monto',8,2);
            $table->timestamps();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuenta_detalles');
    }
}
