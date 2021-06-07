<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCementerios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cementerios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("nombre");
            $table->unsignedInteger("maximo");
            $table->tinyInteger('estado')->default(1);
            $table->string('motivo_baja')->nullable();
            $table->date('fecha_baja')->nullable();
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
        Schema::dropIfExists('cementerios');
    }
}
