<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetencionesTipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retencions', function (Blueprint $table) {
            $table->boolean('tipo')->default(0);//Tipo indice el tipo de retención 0= Empleado 1= Patronal
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retencions', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
