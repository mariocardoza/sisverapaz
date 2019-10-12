<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditarForaneasDeLosPresupuestos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropForeign('presupuestos_categoria_id_foreign');
            $table->dropColumn('categoria_id');
        });

        Schema::table('presupuestodetalles', function (Blueprint $table) {
            $table->dropForeign('presupuestodetalles_catalogo_id_foreign');
            $table->dropColumn('catalogo_id');
            $table->string('material_id');
            $table->foreign('material_id')->references('id')->on('materiales');
            $table->integer('estado')->unsigned()->default(1);
        });

        Schema::table('solicitudcotizacions', function (Blueprint $table) {
            $table->dropForeign('solicitudcotizacions_solicitud_id_foreign');
            $table->dropColumn('solicitud_id');
            $table->bigInteger('proyecto_id')->unsigned()->nullable();
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('requisicion_id')->references('id')->on('requisiciones');
        });

        //Schema::dropIfExists('presupuesto_solicituds');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->bigInteger('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });

        Schema::table('presupuestodetalles', function (Blueprint $table) {
            $table->dropForeign('presupuestodetalles_material_id_foreign');
            $table->dropColumn('material_id');
            $table->bigInteger('catalogo_id')->unsigned();
            $table->foreign('catalogo_id')->references('id')->on('catalogos');
            $table->dropColumn('estado');
        });

        Schema::table('solicitudcotizacions', function (Blueprint $table) {
            $table->dropForeign('solicitudcotizacions_proyecto_id_foreign');
            $table->dropForeign('solicitudcotizacions_requisicio_id_foreign');
            $table->dropColumn('proyecto_id');
            $table->bigInteger('solicitud_id')->unsigned()->nullable();
            $table->foreign('solicitud_id')->references('id')->on('presupuesto_solicituds');
        });

    }
}
