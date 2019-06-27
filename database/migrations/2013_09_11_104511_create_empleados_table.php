<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('dui')->unique();
            $table->string('nit')->unique();
            $table->string('sexo');
            $table->string('telefono_fijo')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('celular')->unique();
            $table->string('direccion');
            $table->date('fecha_nacimiento');
            $table->string('num_cuenta')->nullable();
            $table->string('num_contribuyente')->nullable();
            $table->string('num_seguro_social')->nullable();
            $table->string('num_afp')->nullable();
            $table->integer('estado')->unsigned()->default(1);
            $table->string('es_usuario')->default('no');
            $table->string('avatar')->default('avatar.jpg');
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
        Schema::dropIfExists('empleados');
    }
}
