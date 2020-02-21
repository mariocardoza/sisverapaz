<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectoEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalleplanillas', function (Blueprint $table) {
            $table->string('cargoproyecto_id')->nullable();
            $table->foreign('cargoproyecto_id')->references('id')->on("cargo_proyectos");
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
            $table->dropForeign('detalleplanillas_cargoproyecto_id_foreign');
            $table->dropColumn('cargoproyecto_id');
        });
    }
}
