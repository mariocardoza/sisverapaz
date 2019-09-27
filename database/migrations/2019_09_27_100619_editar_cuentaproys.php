<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditarCuentaproys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuentaproys', function (Blueprint $table) {
            $table->double('monto',8,2)->nullable();
            $table->dropColumn('banco');
            $table->bigInteger('banco_id')->nullable()->unsigned();
            $table->foreign('banco_id')->references('id')->on('bancos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuentaproys', function (Blueprint $table) {
            $table->dropColumn('monto');
            $table->string('banco');
            $table->dropForeign('cuentaproys_banco_id_foreign');
            $table->dropColumn('banco_id');
        });
    }
}
