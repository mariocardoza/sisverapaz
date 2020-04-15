<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditarConstruccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('construccions', function (Blueprint $table) {
            $table->dropForeign('construccions_impuesto_id_foreign');
            $table->dropColumn('impuesto_id');
            $table->unsignedInteger('estado')->default(1);
            $table->double('fiestas',8,2);
            $table->double('impuesto',8,2);
            $table->double('total',8,2);
            $table->date('fecha_pago')->nullable();
            $table->bigInteger('inmueble_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('construccions', function (Blueprint $table) {
            $table->bigInteger('impuesto_id')->unsigned()->nullable();
            $table->foreign('impuesto_id')->references('id')->on("impuestos");
            $table->dropColumn('estado');
            $table->dropColumn('fiestas');
            $table->dropColumn('impuesto');
            $table->dropColumn('total');
            $table->dropColumn('fecha_pago');
            $table->dropColumn('inmueble_id');
        });
    }
}
