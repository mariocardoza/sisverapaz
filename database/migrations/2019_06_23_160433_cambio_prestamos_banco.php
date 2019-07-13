<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambioPrestamosBanco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropColumn('banco');
        });
        Schema::table('prestamos', function (Blueprint $table) {
            $table->bigInteger('banco_id')->unsigned();
            $table->foreign('banco_id')->references('id')->on('bancos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropForeign('prestamos_banco_id_foreign');
            $table->dropColumn('banco_id');
        });
        Schema::table('prestamos', function (Blueprint $table) {
            $table->string('banco');
        });
    }
}
