<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInmueblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inmuebles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero_catastral')->nullable();
            $table->bigInteger('contribuyente_id')->unsigned();
            $table->string('direccion_inmueble');
            $table->double('ancho_inmueble')->nullable();
            $table->double('largo_inmueble')->nullable();
            $table->string('numero_escritura')->nullable();
            $table->double('metros_acera',20,2);
            $table->tinyInteger('estado');
            $table->float('latitude', 20,  18);
            $table->float('longitude', 20, 18);
            $table->string('numero_cuenta');
            $table->foreign('contribuyente_id')->references('id')->on('contribuyentes');
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
        Schema::dropIfExists('inmuebles');
    }
}
