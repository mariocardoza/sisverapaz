<?php

use Illuminate\Database\Seeder;
use App\Configuracion;
use App\Porcentaje;

class ConfiguracionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'configuracions',
            'porcentajes',
        ]);

        $con=new Configuracion();
        $con->direccion_alcaldia='Calle Norberto Marroquín, Barrio Mercedes';
        $con->nit_alcaldia='1013-011290-001-2';
        $con->licitacion=50000;
        $con->telefono_alcaldia='2345-6789';
        $con->escudo_alcaldia='logo_alcaldia_2020-02-23-09-30-42-pm.png';
        $con->nacimiento_alcalde='1950-01-01';
        $con->save();

        
        $por= new Porcentaje();
        $por->nombre='Renta';
        $por->nombre_simple='renta';
        $por->porcentaje=0.00;
        $por->save();

        $por= new Porcentaje();
        $por->nombre='IVA';
        $por->nombre_simple='iva';
        $por->porcentaje=0.00;
        $por->save();

        $por= new Porcentaje();
        $por->nombre='Fiestas Patronales';
        $por->nombre_simple='fiestas';
        $por->porcentaje=0.00;
        $por->save();

        $por= new Porcentaje();
        $por->nombre='Construcciones';
        $por->nombre_simple='construccion';
        $por->porcentaje=0.00;
        $por->save();
    }

    public function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
