<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumbradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumbrados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('detalle');
            $table->string('reporto')->nullable();
            $table->string('email')->nullable();
            $table->decimal("lat", 20, 13);
            $table->decimal("lng", 20, 13);
            $table->date('fecha');
            $table->text('direccion');
            $table->string('tipo_lampara');
            $table->date('fecha_reparacion')->nullable();
            $table->string('detalle_reparacion')->nullable();
            $table->text('acta')->nullable();
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
        Schema::dropIfExists('alumbrados');
    }
}
