<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoFondocatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fondocats', function (Blueprint $table) {
            $table->bigInteger('estado')->unsigned()->nullable();
            $table->date('fechabaja')->nullable();
            $table->string('motivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fondocats', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('fechabaja');
            $table->dropColumn('motivo');
        });
    }
}
