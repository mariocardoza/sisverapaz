<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('direccion_alcaldia')->nullable();
            $table->string('telefono_alcaldia')->nullable();
            $table->string('fax_alcaldia')->nullable();
            $table->string('email_alcaldia')->nullable();
            $table->string('nit_alcaldia')->nullable();
            $table->text('escudo_alcaldia');
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
        Schema::dropIfExists('configuracions');
    }
}
