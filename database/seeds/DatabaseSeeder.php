<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // La creación de datos de roles debe ejecutarse primero
        $this->call(RoleTableSeeder::class);
        factory(App\Contribuyente::class,50)->create();
        factory(App\Proveedor::class,50)->create();
    }
}
