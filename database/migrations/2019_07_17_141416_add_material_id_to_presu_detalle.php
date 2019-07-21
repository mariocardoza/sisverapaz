<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaterialIdToPresuDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestounidaddetalles', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->dropColumn('unidad_medida');
            $table->string('material_id');
            $table->foreign('material_id')->references('id')->on('materiales');
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
            $table->dropForeign('presupuestounidaddetalles_material_id_foreign');
            $table->dropColumn('material_id');
            $table->string('descripcion');
            $table->string('unidad_medida');
        });
    }
}
