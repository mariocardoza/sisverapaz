<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstadoToCuentaprincipals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuentaprincipals', function (Blueprint $table) {
            $table->date('fecha_baja')->nullable();
            $table->string('motivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuentaprincipals', function (Blueprint $table) {
            $table->dropColumn('fecha_baja');
            $table->dropColumn('motivo');
        });
    }
}
