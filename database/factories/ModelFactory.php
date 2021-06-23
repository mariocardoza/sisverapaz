<?php
use App\Contribuyente;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Contribuyente::class,function (Faker\generator $faker){
    return [
        'nombre' => $faker->name,
        'dui' => random_int(0,99999999).'-'.random_int(0,1),
        'nit' => random_int(0,9999).'-'.random_int(0,999999).'-'.random_int(0,999).'-'.random_int(0,1),
        'nacimiento' => $faker->date($format = 'Y-m-d', $max = '2000-01-01'),
        'direccion' => $faker->address,
        'telefono' => random_int(6000,7999).'-'.random_int(0,9999),
        'sexo' => 'Másculino',
        'estado' => 1,
        'departamento_id'=>10,
        'municipio_id'=>175,
    ];
});

$factory->define(App\Proveedor::class,function (Faker\generator $faker){
    return [
        'nombre' => $faker->name,
        'direccion' => $faker->address,
        'telefono' => random_int(6000,7999).'-'.random_int(0,9999),
        'email' => $faker->unique()->safeEmail,
        'numero_registro' => random_int(6000,7999).'-'.random_int(0,9999),
        'nit' => random_int(0,9999).'-'.random_int(0,999999).'-'.random_int(0,999).'-'.random_int(0,1),
        'estado' => 1,
    ];
});
