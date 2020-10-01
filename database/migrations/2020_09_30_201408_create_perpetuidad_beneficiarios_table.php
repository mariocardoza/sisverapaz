<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerpetuidadBeneficiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpetuidad_beneficiarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('perpetuidad_id')->unsigned();
            $table->string('beneficiario');
            $table->date('fecha_entierro');
            $table->integer('estado')->default(1);
            $table->date('fecha_exhumacion')->nullable();
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
        Schema::dropIfExists('perpetuidad_beneficiarios');
    }
}
