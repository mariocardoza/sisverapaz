<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestoSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuesto_solicituds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('presupuesto_id')->unsigned();
          //  $table->bigInteger('solicitudcotizacion_id')->unsigned();
            $table->integer('categoria_id');
            $table->integer('estado')->default(1);
            $table->boolean('seleccionado')->default(false);
            $table->foreign('presupuesto_id')->references('id')->on('presupuestos');
          //  $table->foreign('solicitudcotizacion_id')->references('id')->on('solicitudcotizacions');
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
        Schema::dropIfExists('presupuesto_solicituds');
    }
}
