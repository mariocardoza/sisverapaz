<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambiarPrestamoIdPorPrestamosFloatAPlanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->dropForeign('planillas_prestamo_id_foreign');
            $table->dropColumn('prestamo_id');
            $table->double('prestamos',8,2)->nullable();
            $table->double('descuentos',8,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->dropColumn('prestamos');
            $table->dropColumn('descuentos');
            $table->bigInteger('prestamo_id')->unsigned()->nullable();
            $table->foreign('prestamo_id')->references('id')->on("prestamos");
        });
    }
}
