<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampoPerpetuidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perpetuidads', function (Blueprint $table) {
            $table->date('fecha_adquisicion')->nullable();
            $table->decimal('fiestas')->nullable();
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
            $table->dropColumn('fecha_adquisicion');
            $table->dropColumn('fiestas');
        });
    }
}
