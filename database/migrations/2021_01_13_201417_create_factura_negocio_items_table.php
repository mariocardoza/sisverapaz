<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaNegocioItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_negocio_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('facturanegocio_id');
            $table->double('porcentaje',8,2);
            $table->bigInteger('rubro_id')->unsigned();
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factura_negocio_items');
    }
}
