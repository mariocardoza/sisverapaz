<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudRequisicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_requisicions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('estado')->default(1);
            $table->bigInteger('cuenta_id')->unsigned()->nullable();
            $table->date('fecha_acta')->nullable();
            $table->date('nombre_archivo')->nullable();
            $table->timestamps();
        });

        Schema::table('requisiciones', function(Blueprint $table){
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
        Schema::dropIfExists('solicitud_requisicions');

        Schema::table('requisiciones', function(Blueprint $table){
            $table->dropColumn('solirequi_id');
        });
    }
}
