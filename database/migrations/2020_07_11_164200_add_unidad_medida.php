<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnidadMedida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudcotizaciondetalles', function (Blueprint $table) {
            $table->integer('unidad_medida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudcotizaciondetalles', function (Blueprint $table) {
            $table->dropColumn('unidad_medida');
        });
    }
}
