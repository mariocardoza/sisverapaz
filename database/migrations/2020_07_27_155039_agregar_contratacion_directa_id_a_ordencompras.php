<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarContratacionDirectaIdAOrdencompras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordencompras', function (Blueprint $table) {
            $table->integer('tipo')->default(1);
            $table->bigInteger('contratacion_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordencompras', function (Blueprint $table) {
            $table->dropColumn('tipo');
            $table->dropColumn('contratacion_id');
        });
    }
}
