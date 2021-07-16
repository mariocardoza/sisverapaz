<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->double('porcentaje',10,2);
            $table->integer('estado')->default(1);
            $table->boolean('es_formula')->default(0);
            $table->unsignedBigInteger('categoriarubro_id');
            $table->foreign('categoriarubro_id')->references('id')->on('categoria_rubros');
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
        Schema::dropIfExists('rubros');
    }
}
