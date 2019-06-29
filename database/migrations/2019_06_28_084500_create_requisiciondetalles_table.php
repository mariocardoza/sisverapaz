<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisiciondetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisiciondetalles', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->float('cantidad',8,2);
            $table->string('descripcion');
            $table->string('unidad_medida');
            $table->string('requisicion_id');
            $table->foreign('requisicion_id')->references('id')->on('requisiciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisiciondetalles');
    }
}
