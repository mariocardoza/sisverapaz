<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('categoriadescuento_id');
            $table->bigInteger('empleado_id')->unsigned();
            $table->double('cuota',8,2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->integer('estado')->default(1);
            $table->foreign('categoriadescuento_id')->references('id')->on('categoria_descuentos');
            $table->foreign('empleado_id')->references('id')->on('empleados');
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
        Schema::dropIfExists('descuentos');
    }
}
