<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditarFondos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('fondos');
        Schema::create('fondos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->bigInteger('cuenta_id')->unsigned();
            $table->bigInteger('proyecto_id')->unsigned();
            $table->double('monto',8,2);
            $table->double('monto_disponible',8,2);
            $table->timestamps();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fondos');
    }
}
