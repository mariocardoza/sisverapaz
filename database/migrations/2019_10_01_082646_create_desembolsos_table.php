<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesembolsosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desembolsos', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->double('monto',8,2);
            $table->string('detalle');
            $table->bigInteger('cuenta_id')->unsigned()->nullable();
            $table->bigInteger('cuentaproy_id')->unsigned()->nullable();
            $table->integer('estado')->default(1); // 1: pendiente 2: anulado  3:realizado
            $table->string('motivo')->nullable();
            $table->date('fecha_motivo')->nullable();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->foreign('cuentaproy_id')->references('id')->on('cuentaproys');
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
        Schema::dropIfExists('desembolsos');
    }
}
