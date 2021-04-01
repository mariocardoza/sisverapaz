<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Factura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('mueble_id')->unsigned();
            $table->double('porcentajeFiestas',8,2)->nullable()->default(5);
            $table->string('mesYear', 10);
            $table->date('fechaVencimiento');
            $table->string('codigo');
            $table->double('subTotal',12,2);
            $table->double('pagoTotal',12,2);
            $table->double('mora',12,2)->default(0);
            $table->double('intereses',12,2)->default(0);
            $table->integer('estado')->unsigned()->default(1);
            $table->foreign('mueble_id')->references('id')->on('inmuebles');
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
        Schema::dropIfExists('facturas');
    }
}