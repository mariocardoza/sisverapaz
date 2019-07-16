<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsNegocios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table("negocios", function (Blueprint $table) {
        //$table->double('lat', 15, 8)->change();
       // $table->double('lng', 15, 8)->change();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('negocios', function (Blueprint $table) {
        //$table->dropColumn('lat');
        //$table->dropColumn('lng');
      });
    }
}
