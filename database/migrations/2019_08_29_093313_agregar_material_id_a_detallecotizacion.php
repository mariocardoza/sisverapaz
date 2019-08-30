<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarMaterialIdADetallecotizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detallecotizacions', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->string('material_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detallecotizacions', function (Blueprint $table) {
            $table->dropColumn('material_id');
            $table->string('desripcion');
        });
    }
}
