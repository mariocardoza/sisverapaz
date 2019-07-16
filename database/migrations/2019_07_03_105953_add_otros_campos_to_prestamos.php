<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtrosCamposToPrestamos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->float('tasa_interes',8,2)->nullable();
            $table->date('fecha_corte')->nullable();
            $table->string('prestamotipo_id')->nullable();
            $table->foreign('prestamotipo_id')->references('id')->on('prestamotipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_fin');
            $table->dropColumn('tasa_interes');
            $table->dropColumn('fecha_corte');
            $table->dropForeign('prestamos_prestamotipo_id_foreign');
            $table->dropColumn('prestamotipo_id');
        });
    }
}
