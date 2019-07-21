<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnCosto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tiposervicios', function (Blueprint $table) {
            $table->float('costo', 5, 2);
            $table->tinyInteger('isObligatorio');            
            $table->tinyInteger('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tiposervicios', function(Blueprint $table){
            $table->dropColumn('costo');
            $table->dropColumn('isObligatorio');
            $table->dropColumn('estado');
        });
    }
}
