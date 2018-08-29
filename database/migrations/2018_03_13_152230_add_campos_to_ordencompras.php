<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposToOrdencompras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordencompras', function (Blueprint $table) {
            $table->bigInteger('cotizacion_id')->unsigned();
            $table->string('numero_orden');
            $table->string('observaciones');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->string('direccion_entrega');
            $table->string('adminorden');
            $table->foreign('cotizacion_id')->references('id')->on('cotizacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordencompras', function (Blueprint $table) {
            $table->dropForeign('ordencompras_cotizacion_id_foreign');
            $table->dropColumn('cotizacion_id');
            $table->dropColumn('numero_orden');
            $table->dropColumn('observaciones');
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_fin');
            $table->dropColumn('direccion_entrega');
            $table->dropColumn('adminorden');
        });
    }
}
