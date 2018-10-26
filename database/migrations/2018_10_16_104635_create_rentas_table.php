<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_pago'); //Mensual, Quincenal semanal
            $table->string('tramo');     //I,II,III,IV
            $table->double('desde',8,2);     //Valor inicial
            $table->double('hasta',8,2);     //Valor final
            $table->double('exceso',8,2);    //salario - exceso al resultado se le aplica el porcentaje
            $table->double('porcentaje',8,2);//Porcentaje a aplicar sobre diferencia
            $table->double('cuota_fija',8,2);//Valor fijo a pagar
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
        Schema::dropIfExists('rentas');
    }
}
