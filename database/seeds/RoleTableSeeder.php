<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->truncateTables([
            'role_user',
            'roles',
            'users'
        ]);

      $role = new Role();
      $role->name = 'admin';
      $role->description = 'Administrador';
      $role->save();

      $role = new Role();
      $role->name = 'uaci';
      $role->description = 'Jefe de la Unidad de Adquisiciones y Contrataciones Institucionales';
      $role->save();

      $role = new Role();
      $role->name = 'tesoreria';
      $role->description = 'Jefe de Tesorería';
      $role->save();

      $role = new Role();
      $role->name = 'catastro';
      $role->description = 'Jefe de Registro y Control Tributario';
      $role->save();

      $role = new Role();
      $role->name = 'colector';
      $role->description = 'Colecturía';
      $role->save();

      $role = new Role();
      $role->name = 'usuario';
      $role->description = 'Usuario';
      $role->save();
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
