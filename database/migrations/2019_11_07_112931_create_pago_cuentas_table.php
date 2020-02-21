<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_cuentas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('nit');
            $table->string('dui')->nullable();
            $table->string('concepto');
            $table->string('direccion');
            $table->double('pago',8,2);
            $table->double('renta',8,2);
            $table->double('liquido',8,2);
            $table->integer('estado')->default(1);
            $table->string('catorcena_id');
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
        Schema::dropIfExists('pago_cuentas');
    }
}
