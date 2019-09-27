<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaproyDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentaproy_detalles', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->bigInteger('cuentaproy_id')->unsigned();
            $table->string('accion');
            $table->integer('tipo'); /// 1 ingreso, 2 egreso
            $table->double('monto',8,2);
            $table->timestamps();
            $table->foreign('cuentaproy_id')->references('id')->on('cuentaproys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuentaproy_detalles');
    }
}
