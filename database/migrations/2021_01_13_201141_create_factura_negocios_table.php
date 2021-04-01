<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_negocios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('negocio_id')->unsigned();
            $table->string('mesYear');
            $table->date('fechaVencimiento');
            $table->string('codigo');
            $table->double('pagoTotal',12,2);
            $table->double('subTotal',12,2);
            $table->double('mora',12,2)->default(0);
            $table->double('intereses',12,2)->default(0);
            $table->integer('estado')->default(1);
            $table->double('porcentajeFiestas',8,2);
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
        Schema::dropIfExists('factura_negocios');
    }
}
