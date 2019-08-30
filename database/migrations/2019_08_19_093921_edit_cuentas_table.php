<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuentas', function (Blueprint $table) {
            $table->dropForeign('cuentas_proyecto_id_foreign');
            $table->dropColumn('proyecto_id');
            $table->dropColumn('banco');
            $table->string('nombre');
            $table->bigInteger('banco_id')->unsigned();
            $table->foreign('banco_id')->references('id')->on('bancos');
            $table->integer('principal')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuentas', function (Blueprint $table) {
            $table->dropForeign('cuentas_banco_id_foreign');
            $table->dropColumn('banco_id');
            $table->dropColumn('nombre');
            $table->dropColumn('principal');
            $table->bigInteger('proyecto_id')->unsigned();
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
        });
    }
}
