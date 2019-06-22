<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambiosDatosplanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->dropColumn('isss');
            $table->dropColumn('afp');
            $table->dropColumn('insaforp');
        });
        Schema::table('planillas', function (Blueprint $table) {
            $table->double('issse',8,2);
            $table->double('isssp',8,2);
            $table->double('afpe',8,2);
            $table->double('afpp',8,2);
            $table->double('insaforpp',8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('planillas', function (Blueprint $table) {
            $table->dropColumn('issse');
            $table->dropColumn('isssp');
            $table->dropColumn('afpe');
            $table->dropColumn('afpp');
            $table->dropColumn('insaforpp');
        });
    }
}
