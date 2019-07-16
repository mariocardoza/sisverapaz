<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambioRetenciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('retencions', function (Blueprint $table) {
          $table->dropColumn('isss');
          $table->dropColumn('afp');
          $table->dropColumn('insaforp');
          $table->string('nombre'); //El nombre de la retención AFP,ISSS
          $table->double('porcentaje',8,2);//Porcentaje de retención según ley
          $table->double('techo',8,2);  //El máximo cotizable según institución isss=1,000 afp=6,500...
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('retencions', function (Blueprint $table) {
          $table->dropColumn('nombre');
          $table->dropColumn('porcentaje');
          $table->dropColumn('techo');
          $table->double('isss',8,2);
          $table->double('afp',8,2);
          $table->double('insaforp',8,2);
      });
    }
}
