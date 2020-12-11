<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoFieldToPerpetuidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perpetuidads', function (Blueprint $table) {
            $table->integer('estado')->default(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perpetuidads', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
