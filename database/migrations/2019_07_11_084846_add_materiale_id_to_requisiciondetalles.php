<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaterialeIdToRequisiciondetalles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisiciondetalles', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->string('materiale_id');
            //hacer relacion despues
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisiciondetalles', function (Blueprint $table) {
            $table->string('descripcion');
            $table->dropColumn('materiale_id');
        });
    }
}
