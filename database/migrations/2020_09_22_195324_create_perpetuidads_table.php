<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerpetuidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpetuidads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contribuyente_id')->unsigned();
            $table->bigInteger('cementerio_id')->unsigned();
            $table->string('tipo');
            $table->double('ancho',8,2);
            $table->double('largo',8,2);
            $table->string('norte')->nullable();
            $table->string('sur')->nullable();
            $table->string('oriente')->nullable();
            $table->string('poniente')->nullable();
            $table->double('costo',8,2);
            $table->decimal("lat", 20, 13);
            $table->decimal("lng", 20, 13);
            $table->date('fecha_adquisicion')->nullable();
            $table->decimal('fiestas')->nullable();
            $table->integer('estado')->default(1)->unsigned();
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
        Schema::dropIfExists('perpetuidads');
    }
}
