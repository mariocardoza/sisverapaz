<?php

use Illuminate\Database\Seeder;
use App\Renta;
use App\Retencion;

class RentaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
       $this->truncateTables([
             'rentas',
             'retencions'
         ]);
         $pago=array("Mensual","Quincenal","Semanal");
         $tramo_m=array("I","II","III","IV");
         $desde_m=array("0.01","472.01","895.25","2038.11");
         $hasta_m=array("472.00","895.24","2038.10","0");
         $porcentaje_m=array("0","10","20","30");
         $exceso_m=array("0","472.00","895.24","2038.10");
         $cuota_m=array("0","17.67","60.00","288.57");

         $tramo_q=array("I","II","III","IV");
         $desde_q=array("0.01","236.01","447.63","1019.06");
         $hasta_q=array("236.00","447.62","1019.05","0");
         $porcentaje_q=array("0","10","20","30");
         $exceso_q=array("0","236.00","447.62","1019.05");
         $cuota_q=array("0","8.83","30.00","144.28");

         $tramo_s=array("I","II","III","IV");
         $desde_s=array("0.01","118.01","223.82","509.53");
         $hasta_s=array("118.00","223.81","509.52","0");
         $porcentaje_s=array("0","10","20","30");
         $exceso_s=array("0","118.00","223.81","509.52");
         $cuota_s=array("0","4.42","15.00","72.14");
         for($i=0;$i<4;$i++){
           Renta::create([
             'tipo_pago' => $pago[0],
             'tramo' => $tramo_m[$i],
             'desde' => $desde_m[$i],
             'hasta' => $hasta_m[$i],
             'porcentaje' => $porcentaje_m[$i],
             'exceso' => $exceso_m[$i],
             'cuota_fija' => $cuota_m[$i]
           ]);
           Renta::create([
             'tipo_pago' => $pago[1],
             'tramo' => $tramo_q[$i],
             'desde' => $desde_q[$i],
             'hasta' => $hasta_q[$i],
             'porcentaje' => $porcentaje_q[$i],
             'exceso' => $exceso_q[$i],
             'cuota_fija' => $cuota_q[$i]
           ]);
           Renta::create([
             'tipo_pago' => $pago[2],
             'tramo' => $tramo_s[$i],
             'desde' => $desde_s[$i],
             'hasta' => $hasta_s[$i],
             'porcentaje' => $porcentaje_s[$i],
             'exceso' => $exceso_s[$i],
             'cuota_fija' => $cuota_s[$i]
           ]);

         }
         Retencion::create([
           'nombre' => 'ISSS',
           'porcentaje' => 3,
           'techo' => 1000,
         ]);
         Retencion::create([
           'nombre' => 'AFP',
           'porcentaje' => 7.25,
           'techo' => 6500,
         ]);

         Retencion::create([
           'nombre' => 'INSAFORP',
           'porcentaje' => 6,
           'techo' => 1000,
         ]);
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
