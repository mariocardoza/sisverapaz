<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoRentaADesembolsos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('desembolsos', function (Blueprint $table) {
            $table->float('renta',8,2)->nullable();
            $table->date('fecha_desembolso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('desembolsos', function (Blueprint $table) {
            $table->dropColumn('renta');
            $table->dropColumn('fecha_desembolso');
        });
    }
}
