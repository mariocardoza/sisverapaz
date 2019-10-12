<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarAnioAProyectos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->integer('anio')->nullable()->unsigned();
            $table->dateTime('fecha_acta')->nullable();
            $table->string('motivo_pausa')->nullable();
        });

        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dateTime('fecha_acta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropColumn('anio');
            $table->dropColumn('fecha_acta');
            $table->dropColumn('motivo_pausa');
        });

        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dropColumn('fecha_acta');
        });
    }
}
