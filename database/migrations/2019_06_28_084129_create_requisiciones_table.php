<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisiciones', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('codigo_requisicion');
            $table->string('actividad');
            $table->bigInteger('fondocat_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('observaciones');
            $table->integer('estado')->unsigned()->default(1);
            //$table->foreign('unidad_id')->references('id')->on("unidads");
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
        Schema::dropIfExists('requisiciones');
    }
}
