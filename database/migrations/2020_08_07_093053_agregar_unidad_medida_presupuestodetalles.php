<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarUnidadMedidaPresupuestodetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestodetalles', function (Blueprint $table) {
            $table->string('unidad_medida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuestodetalles', function (Blueprint $table) {
            $table->dropColumn('unidad_medida');
        });
    }
}
