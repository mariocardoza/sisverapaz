<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambioBanco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bancos', function (Blueprint $table) {
            $table->string('motivo')->nullable();
            $table->date('fechabaja')->nullable();
        });
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropColumn('banco');
        });
        Schema::table('prestamos', function (Blueprint $table) {
            $table->bigInteger('banco_id')->unsigned()->nullable();
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
        //
    } 
}
