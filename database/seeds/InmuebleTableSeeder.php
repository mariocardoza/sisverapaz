<?php

use Illuminate\Database\Seeder;

class InmuebleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Inmueble::class, 200)->create()->each(function($i){
            $i->save();
        });
    }
}
