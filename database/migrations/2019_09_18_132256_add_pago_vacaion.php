<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPagoVacaion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacacions', function (Blueprint $table) {
            $table->date('fecha_pago')->nullable();
            $table->double('pago',8,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacacions', function (Blueprint $table) {
            $table->dropColumn('fecha_pago');
            $table->dropColumn('pago');
        });
    }
}
