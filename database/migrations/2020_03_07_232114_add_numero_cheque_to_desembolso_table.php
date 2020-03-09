<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumeroChequeToDesembolsoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('desembolsos', function (Blueprint $table) {
            $table->string("numero_cheque")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('desembolsos', function (Blueprint $table) {
            $table->dropColumn("numero_cheque");
        });
    }
}
