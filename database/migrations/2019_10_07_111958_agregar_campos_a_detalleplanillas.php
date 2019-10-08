<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposADetalleplanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalleplanillas', function (Blueprint $table) {
            $table->string('numero_acuerdo')->nullable();
            $table->bigInteger('unidad_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalleplanillas', function (Blueprint $table) {
            $table->drop('numero_acuerdo');
            $table->drop('unidad_id');
        });
    }
}
