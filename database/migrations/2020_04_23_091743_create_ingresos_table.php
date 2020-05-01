<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cuenta_id')->unsigned();
            $table->text('detalle');
            $table->integer('tipo')->unsigned(); //1: impuesto, 2: partidas de nacimiento, 3: otros ingresos
            $table->double('monto',8,2);
            $table->double('fiestas',8,2);
            $table->date('fecha');
            $table->integer('estado')->unsigned()->default(1);
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
        Schema::dropIfExists('ingresos');
    }
}
