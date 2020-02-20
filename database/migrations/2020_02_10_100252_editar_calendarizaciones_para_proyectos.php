<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditarCalendarizacionesParaProyectos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendarizacions', function (Blueprint $table) {
            $table->bigInteger('proyecto_id')->unsigned();
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->integer('estado')->default(1);
            $table->foreign('proyecto_id')->references('id')->on("proyectos");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendarizacions', function (Blueprint $table) {
            $table->dropForeign('calendarizacions_proyecto_id->foreign');
            $table->dropColumn('inicio');
            $table->dropColumn('fin');
            $table->dropColumn('estado');
            $table->dropColumn('proyecto_id');
        });
    }
}
