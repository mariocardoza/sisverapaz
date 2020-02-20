<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditarTablaLicitaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licitacions', function (Blueprint $table) {
            $table->bigInteger('proyecto_id')->unsigned();
            $table->bigInteger('proveedor_id')->unsigned();
            $table->string('archivo');
            $table->tinyInteger('estado')->default(0);
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licitacions', function (Blueprint $table) {
            $table->dropForeign('licitacions_proyecto_id_foreign');
            $table->dropForeign('licitacions_proveedor_id_foreign');
            $table->dropColumn('proyecto_id');
            $table->dropColumn('proveedor_id');
            $table->dropColumn('archivo');
            $table->dropColumn('estado');
        });
    }
}
