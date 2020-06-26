<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMesesAPresudetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestounidaddetalles', function (Blueprint $table) {
            $table->integer('enero')->unsigned()->default(0);
            $table->integer('febrero')->unsigned()->default(0);
            $table->integer('marzo')->unsigned()->default(0);
            $table->integer('abril')->unsigned()->default(0);
            $table->integer('mayo')->unsigned()->default(0);
            $table->integer('junio')->unsigned()->default(0);
            $table->integer('julio')->unsigned()->default(0);
            $table->integer('agosto')->unsigned()->default(0);
            $table->integer('septiembre')->unsigned()->default(0);
            $table->integer('octubre')->unsigned()->default(0);
            $table->integer('noviembre')->unsigned()->default(0);
            $table->integer('diciembre')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuestounidaddetalles', function (Blueprint $table) {
            $table->dropColumn('enero');
            $table->dropColumn('febrero');
            $table->dropColumn('marzo');
            $table->dropColumn('abril');
            $table->dropColumn('mayo');
            $table->dropColumn('junio');
            $table->dropColumn('julio');
            $table->dropColumn('agosto');
            $table->dropColumn('septiembre');
            $table->dropColumn('octubre');
            $table->dropColumn('noviembre');
            $table->dropColumn('diciembre');
        });
    }
}
