<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToPresupuestounidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presupuestounidads', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->integer('anio');
            $table->foreign('user_id')->references('id')->on('users');
            $table->dropColumn('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presupuestounidads', function (Blueprint $table) {
            $table->dropForeign('presupuestounidads_user_id_foreign');
            $table->dropColumn('anio');
            $table->dropColumn('user_id');
            $table->float('total')->nullable();
        });
    }
}
