<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacturaItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('factura_id')->unsigned();
            $table->integer('tipoinmueble_id')->unsigned();

            $table->double('precio_servicio',8,2);
            $table->integer('estado')->unsigned()->default(1);

            $table->foreign('factura_id')->references('id')->on('facturas');
            $table->foreign('tipoinmueble_id')->references('id')->on('inmueble_tiposervicio');
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
        Schema::dropIfExists('factura_items');
    }
}
