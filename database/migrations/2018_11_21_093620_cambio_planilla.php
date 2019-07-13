<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambioPlanilla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->bigInteger('datoplanilla_id')->unsigned()->nullable();
            $table->foreign('datoplanilla_id')->references('id')->on('datoplanillas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->dropForeign('planillas_datoplanilla_id_foreign');
            $table->dropColumn('datoplanilla_id');
        });
    }
}
