<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraDirectasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_directas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('material_id');
            $table->string('marca')->nullable();
            $table->bigInteger('unidadmedida_id')->unsigned();
            $table->bigInteger('contratacion_id')->unsigned();
            $table->integer('cantidad')->unsigned();
            $table->double('precio',8,2)->nullable();
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
        Schema::dropIfExists('compra_directas');
    }
}
