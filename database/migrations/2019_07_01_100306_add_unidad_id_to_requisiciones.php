<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnidadIdToRequisiciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->bigInteger('unidad_id')->unsigned()->nullable();
            $table->foreign('unidad_id')->references('id')->on('unidads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dropForeign('requisiciones_unidad_id_foreign');
            $table->dropColumn('unidad_id');
        });
    }
}
