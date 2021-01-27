<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoraNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mora_negocios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('negocio_id')->unsigned();
            $table->double('mora',8,2)->nullable()->default(0);
            $table->integer('porcentaje');
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('mora_negocios');
    }
}
