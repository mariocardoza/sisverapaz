<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacacions', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->bigInteger('detalleplanilla_id')->unsigned();
            $table->foreign('detalleplanilla_id')->references('id')->on('detalleplanillas');
            $table->integer('estado')->default(0);//0->Sin vacaciones asignadas, 1->Con vacaciones asignadas, 2->Vacaciones pagadas
            $table->string('anio',5);
            $table->date('fecha_vacacion')->nullable();
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
        Schema::dropIfExists('vacacions');
    }
}
