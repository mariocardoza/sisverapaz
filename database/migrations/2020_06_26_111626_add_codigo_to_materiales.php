<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodigoToMateriales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materialtable', function (Blueprint $table) {
            $table->string('codigo')->nullable();
            $table->dropColumn('unidad_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materialtable', function (Blueprint $table) {
            $table->dropColumn('codigo');
            $string('unidad_id');
            $table->foreign('unidad_id')->references('id')->on('unidads');
        });
    }
}
