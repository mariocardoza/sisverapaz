<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoRentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_rentas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('dui')->nullable();
            $table->string('nit');
            $table->float('total',8,2);
            $table->float('renta',8,2);
            $table->float('liquido',8,2);
            $table->text('concepto');
            $table->integer('estado')->default(1);
            $table->date('fecha_orden')->nullable();
            $table->datetime('fecha_pago')->nullable();
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
        Schema::dropIfExists('pago_rentas');
    }
}
