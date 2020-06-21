<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitacoraAlumbradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_alumbrados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('alumbrado_id')->unsigned();
            $table->date('fecha');
            $table->string("accion");
            $table->string("empleado");
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
        Schema::dropIfExists('bitacora_alumbrados');
    }
}
