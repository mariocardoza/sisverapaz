<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaInicioToDetalleplanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalleplanillas', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable();
            $table->string('cargo_id')->nullable();
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
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('cargo_id');
        });
    }
}
