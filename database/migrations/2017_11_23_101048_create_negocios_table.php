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
            $table->string('nombre', 50)->nullable();
            $table->double('lat',20,18)->default(0);
            $table->double('lng',20,18)->default(0);
            $table->bigInteger('rubro_id')->unsigned();
            $table->integer('estado')->default(1);
            $table->double('capital',8,2)->default(0);
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
