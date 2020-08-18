<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCuentaIdAContratacionesdirectas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contratacion_directas', function (Blueprint $table) {
            $table->bigInteger('cuenta_id')->unsigned();
            $table->bigInteger('proveedor_id')->unsigned()->nullable();
            $table->double('renta',8,2)->nullable();
            $table->double('total',8,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contratacion_directas', function (Blueprint $table) {
            $table->dropColumn('cuenta_id');
            $table->dropColumn('proveedor_id');
            $table->dropColumn('renta');
            $table->dropColumn('total');
        });
    }
}
