<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNCuentaContribuyentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contribuyentes', function (Blueprint $table) {
            $table->string('numero_cuenta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contribuyentes', function (Blueprint $table) {
            $table->dropColumn('numero_cuenta');
        });
    }
}
