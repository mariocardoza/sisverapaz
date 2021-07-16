<?php

use Illuminate\Database\Seeder;
use App\Departamento;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            ['codigo' => '01', 'nombre' => 'Ahuachapán'],
            ['codigo' => '02', 'nombre' => 'Santa Ana'],
            ['codigo' => '03', 'nombre' => 'Sonsonate'],
            ['codigo' => '04', 'nombre' => 'La Libertad'],
            ['codigo' => '05', 'nombre' => 'San Salvador'],
            ['codigo' => '06', 'nombre' => 'Chalatenango'],
            ['codigo' => '07', 'nombre' => 'Cuscatlán'],
            ['codigo' => '08', 'nombre' => 'La Paz'],
            ['codigo' => '09', 'nombre' => 'Cabañas'],
            ['codigo' => '10', 'nombre' => 'San Vicente'],
            ['codigo' => '11', 'nombre' => 'Usulután'],
            ['codigo' => '12', 'nombre' => 'San Miguel'],
            ['codigo' => '13', 'nombre' => 'Morazán'],
            ['codigo' => '14', 'nombre' => 'La Unión']];
    
          if (Departamento::all()->count() < 1){
            foreach ($states as $state) {
              Departamento::create([
                'nombre' => $state['nombre'],
                'codigo' => $state['codigo']
              ]);
            }
          }
    
    }
}
