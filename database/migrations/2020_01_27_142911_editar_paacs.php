<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditarPaacs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paacs', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->bigInteger('paaccategoria_id')->nullable()->unsigned();
            $table->foreign('paaccategoria_id')->references('id')->on('paac_categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paacs', function (Blueprint $table) {
            $table->dropForeign('paacs_paaccategoria_id_foreign');
            $table->dropColumn('paaccategoria_id');
            $table->string('descripcion')->nullable();
        });
    }
}
