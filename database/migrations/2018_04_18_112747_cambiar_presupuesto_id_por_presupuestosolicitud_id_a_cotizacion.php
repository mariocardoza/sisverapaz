<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambiarPresupuestoIdPorPresupuestosolicitudIdACotizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->dropForeign('cotizacions_presupuesto_id_foreign');
            $table->dropColumn('presupuesto_id');
            $table->bigInteger('solicitudcotizacion_id')->unsigned();
            $table->foreign('solicitudcotizacion_id')->references('id')->on('solicitudcotizacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->dropForeign('cotizacions_solicitudcotizacion_id_foreign');
            $table->dropColumn('solicitudcotizacion_id');
            $table->bigInteger('presupuesto_id')->unsigned();
            $table->foreign('presupuesto_id')->references('id')->on('presupuestos');
        });
    }
}
