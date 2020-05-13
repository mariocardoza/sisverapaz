<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCementeriosPosicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cementerios_posiciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("cementerio_id")->unsigned();
            $table->decimal("latitud", 20, 13);
            $table->decimal("longitud", 20, 13);
            $table->timestamps();

            $table->foreign('cementerio_id')->references('id')->on('cementerios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cementerios_posiciones');
    }
}
