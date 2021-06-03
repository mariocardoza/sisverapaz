<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('numero_cuenta');
            $table->bigInteger('banco_id')->unsigned();
            $table->date('fecha_de_apertura');
            $table->string('descripcion')->nullable();
            $table->double('monto_inicial',20,2);
            $table->integer('estado')->default(1);
            $table->date('fecha_de_reasignacion')->nullable();
            $table->string('motivo_reasignacion')->nullable();
            $table->string('nombre');
            $table->integer('anio')->default(date('Y'))->nullable();
            $table->date('fecha_liquidacion')->nullable();
            $table->tinyInteger('tipo_cuenta')->unsigned();
            $table->foreign('banco_id')->references('id')->on('bancos');
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
        Schema::dropIfExists('cuentas');
    }
}
