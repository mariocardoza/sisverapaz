<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarTipoSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudcotizacions', function (Blueprint $table) {
            $table->integer('tipo')->nullable();
            $table->bigInteger('solicitud_id')->unsigned()->nullable();
            $table->bigInteger('requisicion_id')->unsigned()->nullable();
            $table->foreign('requisicion_id')->references('id')->on('requisiciones');
            $table->foreign('solicitud_id')->references('id')->on('presupuesto_solicituds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudcotizacions', function (Blueprint $table) {
          $table->dropColumn('tipo');
          $table->dropColumn('solicitud_id');
          $table->dropColumn('requisicion_id');
          $table->dropForeign('solicitudcotizacions_solicitud_id_foreign');
          $table->dropForeign('solicitudcotizacions_requisicion_id_foreign');
        });
    }
}
