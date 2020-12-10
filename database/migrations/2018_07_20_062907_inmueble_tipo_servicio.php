<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InmuebleTipoServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inmueble_tiposervicio', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('inmueble_id')->unsigned()->nullable();
            $table->bigInteger('tiposervicio_id')->unsigned()->nullable();

            // Relations
            $table->foreign('inmueble_id')->references('id')->on('inmuebles');
            $table->foreign('tiposervicio_id')->references('id')->on('tiposervicios');

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
        Schema::dropIfExists('inmueble_tiposervicio');
    }
}
