<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarProyectoIdADetalleplanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalleplanillas', function (Blueprint $table) {
            //$table->bigInteger('cargo_id')->unsigned()->nullable();
            $table->bigInteger('proyecto_id')->unsigned()->nullable();
            //$table->foreign('cargo_id')->references('id')->on('cargos');
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalleplanillas', function (Blueprint $table) {
            $table->dropForeign('detalleplanillas_proyecto_id_foreign');
            //$table->dropForeign('detalleplanillas_cargo_id_foreign');
            $table->dropColumn('proyecto_id');
            //$table->dropColumn('cargo_id');
        });
    }
}
