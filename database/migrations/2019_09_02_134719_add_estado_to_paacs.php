<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoToPaacs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paacs', function (Blueprint $table) {
            $table->integer('estado')->default(1);
            $table->date('fecha_baja')->nullable();
            $table->string('motivo_baja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paacs', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('fecha_baja');
            $table->dropColumn('motivo_baja');
        });
    }
}
