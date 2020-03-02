<?php

use Faker\Generator as Faker;

$factory->define(App\Inmueble::class, function (Faker $faker) {
    return [
        'numero_catastral'          => $faker->numerify('INMUEBLE#####'),
        'contribuyente_id'          => $faker->numberBetween(1, 50),
        'direccion_inmueble'        => $faker->address(),
        'ancho_inmueble'            => $faker->randomFloat(2, 1),
        'largo_inmueble'            => $faker->randomFloat(2, 1),
        'numero_escritura'          => $faker->numerify('PART###'),
        'latitude'                  => $faker->latitude($min = 13.6440000, $max = 13.6450000),
        'longitude'                 => $faker->longitude($min = -88.8721062, $max = -88.8722062),
        'metros_acera'              => $faker->numberBetween(5, 15),
        'estado'                    => 1
    ];
});
