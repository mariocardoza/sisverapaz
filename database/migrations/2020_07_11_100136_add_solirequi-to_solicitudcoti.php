<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSolirequiToSolicitudcoti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudcotizacions', function (Blueprint $table) {
            $table->string('solirequi_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudcotizacions', function (Blueprint $table) {
            $table->dropColumn('solirequi_id');
        });
    }
}
