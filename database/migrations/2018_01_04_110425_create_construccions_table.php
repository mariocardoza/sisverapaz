<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstruccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construccions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contribuyente_id')->unsigned();
            $table->string('direccion_construccion');
            $table->double('presupuesto',8,2);
            $table->unsignedInteger('estado')->default(1);
            $table->double('fiestas',8,2);
            $table->double('impuesto',8,2);
            $table->double('total',8,2);
            $table->date('fecha_pago')->nullable();
            $table->bigInteger('inmueble_id')->unsigned();
            $table->string('detalle')->nullable();
            $table->foreign('contribuyente_id')->references('id')->on('contribuyentes');
            $table->foreign('inmueble_id')->references('id')->on('inmuebles');
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
        Schema::dropIfExists('construccions');
    }
}
