<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BorrarCamposPlanilla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->dropColumn('mes');
            $table->dropColumn('anio');
            $table->dropColumn('prestamos');
        });

        Schema::table('planillas', function (Blueprint $table) {
            $table->bigInteger('prestamo_id')->unsigned()->nullable();
            $table->foreign('prestamo_id')->references('id')->on('prestamos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
