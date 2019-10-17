<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarProyectoIdADatoplanilla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datoplanillas', function (Blueprint $table) {
            $table->bigInteger('proyecto_id')->unsigned()->nullable();
            //$table->foreign('proyecto_id')->references('id')->on('proyectos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datoplanillas', function (Blueprint $table) {
            //$table->dropForeign('detalleplanillas_proyecto_id_foreign');
            $table->dropColumn('proyecto_id');
        });
    }
}
