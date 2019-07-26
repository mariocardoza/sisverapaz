<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudcotizaciondetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudcotizaciondetalles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('material_id');
            $table->integer('cantidad');
            $table->bigInteger('solicitud_id')->unsigned();
            $table->integer('estado')->default(1);
            $table->foreign('solicitud_id')->references('id')->on('solicitudcotizacions');
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
        Schema::dropIfExists('solicitudcotizaciondetalles');
    }
}
