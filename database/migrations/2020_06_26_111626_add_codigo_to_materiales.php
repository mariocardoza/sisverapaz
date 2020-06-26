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
        Schema::table('materiales', function (Blueprint $table) {
            $table->string('codigo')->nullable();
            $table->dropColumn('unidad_id');
        });

        Schema::table('requisiciones', function (Blueprint $table) {
            $table->integer('combinada')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materiales', function (Blueprint $table) {
            $table->dropColumn('codigo');
            $table->string('unidad_id')->nullable();
        });

        Schema::table('requisiciones', function (Blueprint $table) {
            $table->dropColumn('combinada');
        });
    }
}
