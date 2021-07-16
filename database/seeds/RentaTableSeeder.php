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
      /* $this->truncateTables([
             'rentas',
             'retencions'
         ]);*/
         if (Renta::all()->count() < 1){
          $pago=array("Mensual","Quincenal");
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
          }
          Retencion::create([
            'nombre' => 'ISSSE',
            'porcentaje' => 3,
            'techo' => 1000,
            'tipo' => 0,
          ]);

          Retencion::create([
            'nombre' => 'ISSSP',
            'porcentaje' => 7.5,
            'techo' => 1000,
            'tipo' => 1,
          ]);

          Retencion::create([
            'nombre' => 'AFPE',
            'porcentaje' => 7.25,
            'techo' => 6500,
            'tipo' => 0,
          ]);

          Retencion::create([
            'nombre' => 'AFPP',
            'porcentaje' => 7.75,
            'techo' => 6500,
            'tipo' => 1,
          ]);

          Retencion::create([
            'nombre' => 'INSAFORPP',
            'porcentaje' => 1,
            'techo' => 1000,
            'tipo' => 1,
          ]);
        }
     }
     public function truncateTables(array $tables)
     {
        // DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

         foreach ($tables as $table) {
             DB::table($table)->truncate();
         }

        // DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
     }
}
