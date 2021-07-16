<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negocios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contribuyente_id')->unsigned();
            $table->string('direccion');
            $table->string('nombre', 150)->nullable();
            $table->double('lat',20,18)->default(0);
            $table->double('lng',20,18)->default(0);
            $table->bigInteger('rubro_id')->unsigned();
            $table->integer('estado')->default(1);
            $table->double('capital',12,2)->nullable();
            $table->double('licencia',12,2)->nullable();
            $table->double('otro',12,2)->nullable();
            $table->double('precio_cabezas',12,2)->nullable();
            $table->integer('tipo_cobro');
            $table->integer('numero_cabezas')->nullable();
            $table->boolean('es_granja')->default(0);
            $table->string('numero_cuenta');
            $table->foreign('rubro_id')->references('id')->on('rubros');
            $table->foreign('contribuyente_id')->references('id')->on('contribuyentes');
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
        Schema::dropIfExists('negocios');
    }
}
