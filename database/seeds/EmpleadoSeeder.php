<?php

use Illuminate\Database\Seeder;
use App\Empleado;
use App\Detalleplanilla;
require 'C:\xampp\htdocs\sisverapaz\vendor\autoload.php';


class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');
        for($i=0;$i<50;$i++){
            $s=random_int(0,1);
            if(!$s){
                $n=$faker->firstNameMale; 
                $s='Femenino';
            }else{
                $n=$faker->firstNameFemale; 
                $s='Masculino';
            }
            $empleado=Empleado::create([
                'nombre'=>$n." ".$faker->lastName,
                'dui'=>random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).'-'.random_int(0,9),
                'nit'=>random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9)."-".random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9)."-".random_int(0,9).random_int(0,9).random_int(0,9)."-".random_int(0,9),
                'sexo'=>$s,
                'email'=>$faker->email,
                'telefono_fijo'=>"2".random_int(0,9).random_int(0,9).random_int(0,9)."-".random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9),
                'celular'=>random_int(6,7).random_int(0,9).random_int(0,9).random_int(0,9)."-".random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9),
                'direccion'=>$faker->address,
                'fecha_nacimiento'=>$faker->date($format = 'Y-m-d', $max = '2018-06-01'),
                'num_contribuyente'=>random_int(0,9).random_int(0,9).random_int(0,9).'-'.random_int(0,9),
                'num_seguro_social'=>random_int(100000000,999999999),
                'num_afp'=>random_int(1,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9),
                'estado'=>1
            ]);
            DetallePlanilla::create([
                'empleado_id'=>$empleado->id,
                'salario'=>random_int(250,2000).'.'.random_int(0,99),
                'tipo_pago'=>random_int(1,2),
                'pago'=>random_int(1,2)
            ]);


        }
    }
}
