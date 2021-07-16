<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContribuyentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribuyentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('dui')->nullable();
            $table->string('nit')->nullable();
            $table->date('nacimiento')->nullable();
            $table->string('direccion');
            $table->string('telefono')->nullable();
            $table->string('sexo');
            $table->bigInteger('departamento_id')->nullable();
            $table->bigInteger('municipio_id')->nullable();
            $table->integer('estado')->default(1);
            $table->string('motivo')->nullable();
            $table->date('fechabaja')->nullable();
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
        Schema::dropIfExists('contribuyentes');
    }
}
