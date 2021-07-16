<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\RoleUser;
use App\Empleado;
use App\Porcentaje;
use App\Unidad;
use App\Bitacora;


class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::all()->count() == 0){
            /*$this->truncateTables([
                'role_user',
                'roles',
                'users',
                'empleados',
                'unidads',
                'bitacoras'
            ]);
*/
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
            $role->name = 'proyectos';
            $role->description = 'Jefe unidad de proyectos';
            $role->save();

            $role = new Role();
            $role->name = 'colector';
            $role->description = 'Colecturía';
            $role->save();

            $role = new Role();
            $role->name = 'usuario';
            $role->description = 'Usuario';
            $role->save();

            $emple=new Empleado();
            $emple->nombre="Administrador";
            $emple->dui='00000000-0';
            $emple->nit='0000-000000-000-0';
            $emple->sexo='No definido';
            $emple->email='mariokr.rocker@gmail.com';
            $emple->celular='0000-0000';
            $emple->direccion='Verapaz, San Vicente';
            $emple->fecha_nacimiento='1990-01-01';
            $emple->save();

            $unidad=new Unidad();
            $unidad->nombre_unidad='Despacho municipal';
            $unidad->save();

            $user=new User();
            $user->empleado_id=$emple->id;
            $user->username='administrador';
            $user->email='mariokr.rocker@gmail.com';
            $user->unidad_id=$unidad->id;
            $user->password=bcrypt('sisadmin');
            $user->save();

            $ru=new RoleUser();
            $ru->role_id=1;
            $ru->user_id=$user->id;
            $ru->save();

            /* catastro */
            $emple=new Empleado();
            $emple->nombre="Catastro";
            $emple->dui='111111111-1';
            $emple->nit='1111-111111-111-1';
            $emple->sexo='No definido';
            $emple->email='catastro@catastro.com';
            $emple->celular='1111-1111';
            $emple->direccion='Verapaz, San Vicente';
            $emple->fecha_nacimiento='1990-01-01';
            $emple->es_usuario='si';
            $emple->save();

            $unidad=new Unidad();
            $unidad->nombre_unidad='Registro y Control Tributario';
            $unidad->save();

            $user=new User();
            $user->empleado_id=$emple->id;
            $user->username='catastro';
            $user->email=$emple->email;
            $user->unidad_id=$unidad->id;
            $user->password=bcrypt('awesome');
            $user->save();

            $ru=new RoleUser();
            $ru->role_id=4;
            $ru->user_id=$user->id;
            $ru->save();

            /* tesoreria */
            $emple=new Empleado();
            $emple->nombre="Tesorero";
            $emple->dui='22222222-2';
            $emple->nit='2222-222222-222-2';
            $emple->sexo='No definido';
            $emple->email='tesoreria@tesoreria.com';
            $emple->celular='2222-1111';
            $emple->direccion='Verapaz, San Vicente';
            $emple->fecha_nacimiento='1990-01-01';
            $emple->es_usuario='si';
            $emple->save();

            $unidad=new Unidad();
            $unidad->nombre_unidad='Tesorería';
            $unidad->save();

            $user=new User();
            $user->empleado_id=$emple->id;
            $user->username='tesoreria';
            $user->email=$emple->email;
            $user->unidad_id=$unidad->id;
            $user->password=bcrypt('awesome');
            $user->save();
            
            $ru=new RoleUser();
            $ru->role_id=3;
            $ru->user_id=$user->id;
            $ru->save();

            /* uaci */
            $emple=new Empleado();
            $emple->nombre="Uaci";
            $emple->dui='32222222-2';
            $emple->nit='3322-222222-222-2';
            $emple->sexo='No definido';
            $emple->email='uaci@uaci.com';
            $emple->celular='3222-1111';
            $emple->direccion='Verapaz, San Vicente';
            $emple->fecha_nacimiento='1990-01-01';
            $emple->es_usuario='si';
            $emple->save();

            $unidad=new Unidad();
            $unidad->nombre_unidad='Unidad de Adquisiciones y Contrataciones Institucionales';
            $unidad->save();

            $user=new User();
            $user->empleado_id=$emple->id;
            $user->username='uaci';
            $user->email=$emple->email;
            $user->unidad_id=$unidad->id;
            $user->password=bcrypt('awesome');
            $user->save();
            
            $ru=new RoleUser();
            $ru->role_id=2;
            $ru->user_id=$user->id;
            $ru->save();

            bitacora('Se crearon los registros de prueba por el administrador','User');      
        }
    }

    public function truncateTables(array $tables)
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        //DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
