<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bitacora;
use App\Contrato;
use App\Empleado;
use App\Role;
use DB;
use App\Http\Requests\UsuariosRequest;
use App\Http\Requests\ModificarUsuarioRequest;
use App\Http\Requests\PerfilRequest;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

    }


    public function index(Request $request)
    {
      Auth()->user()->authorizeRoles('admin');

            $estado = $request->get('estado');
            if($estado == "" )$estado=1;
            if ($estado == 1) {
                $usuarios = User::where('username','<>','administrador')->get();
                return view('usuarios.index',compact('usuarios','estado'));
            }
            if ($estado == 2) {
                $usuarios = User::where('username','<>','administrador')->where('estado',$estado)->get();
                return view('usuarios.index',compact('usuarios','estado'));
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      Auth()->user()->authorizeRoles('admin');
      $roles = Role::all();
      $empleados = DB::table('empleados')->where('es_usuario','=','si')
                    ->whereNotExists(function ($query)  {
                         $query->from('users')
                            ->whereRaw('empleados.id = users.empleado_id');
                        })->get();
      return view('usuarios.create',compact('empleados','roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuariosRequest $request)
    {
        try{
            $user = User::create([
                'empleado_id' => $request['name'],
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'unidad_id'=>$request->unidad_id,
            ]);
    
            $user
            ->roles()
            ->attach(Role::find($request->roles));
    
            bitacora('Registró un usuario');
            return array(1,"exito",$user);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $retorno=User::modal_editar($id);
        return $retorno;
        //$roles = Role::all();
       // $usuario = User::find($id);
        //dd($cargos);
        //return view('usuarios.edit',compact('usuario','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        if(isset($request->password) || $request->password != null):
            $this->validar_contraseñas($request->all())->validate();
            $usuario = User::find($id);
            $usuario->username=$request->username;
            $usuario->email=$request->email;
            $usuario->unidad_id=$request->unidad_id;
            $usuario->password = bcrypt($request['password']);
            bitacora('Usuario '.$request['name'].' modificado');
            $usuario->save();
        else:
            $usuario = User::find($id);
            $usuario->username=$request->username;
            $usuario->email=$request->email;
            $usuario->unidad_id=$request->unidad_id;
            bitacora('Usuario '.$request['name'].' modificado');
            $usuario->save();
        endif;

        $rol=$usuario->roleuser;
        $rol->role_id=$request->roles;
        $rol->save();

        return array(1,'usuarios',$usuario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function baja($id,Request $r)
    {
        try{
            $usuarios = User::find($id);
            $role=$usuarios->roleuser->role->description;
            if(Auth()->user()->roleuser->role->description == $role){
                return array(2,"No se puede dar de baja al usuario administrador");
            }else{
                $usuarios->estado=2;
                $usuarios->motivo=$r->motivo;
                $usuarios->fechabaja=date('Y-m-d');
                $usuarios->save();
                bitacora('Dió de baja a un usuario');
                return array(1,"exito");
            }
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }

    }

    public function alta($id)
    {

        //$datos = explode("+", $cadena);
        ////$id=$datos[0];
        //$motivo=$datos[1];
        //dd($id);
        try{
            $usuarios = User::find($id);
            $usuarios->estado=1;
            $usuarios->motivo=null;
            $usuarios->fechabaja=null;
            $usuarios->save();
            Bitacora::bitacora('Dió de alta a un usuario');
            return array(1);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function perfil()
    {
        return view('usuarios.perfil');
    }

    public function modificarperfil($id)
    {
        return view('usuarios.modificarperfil');
    }

    public function updateperfil(PerfilRequest $request)
    {
        //if(Hash::check($request->actual, Auth()->user()->password))
        //{
            $id = $request['id'];
            $usuario = User::find($id);
            $usuario->fill($request->All());
            //dd($request->all());
            bitacora('Modificó su perfil');
            $usuario->save();
            return redirect('home/perfil');
       // }
        //else{
        //    return redirect('home/perfil')->with('error','No coincide con la contraseña actual');
        //}
    }

    public function avatar()
    {
        return View('usuarios.avatar');
    }

    public function actualizaravatar(Request $request){
        $rules = ['avatar' => 'required|image|max:2048*2048*1',];
        $messages = [
            'avatar.required' => 'La imagen es requerida',
            'avatar.image' => 'Formato no permitido',
            'avatar.max' => 'El máximo permitido es 1 MB',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return redirect('avatar')->withErrors($validator);
        }
        else{
            $info = explode(".",$request->file('avatar')->getClientOriginalName());
            $name = str_random(30) . '-' . $request->file('avatar')->getClientOriginalName();
            //dd($info);
            $request->file('avatar')->move('avatars', $request->file('avatar')->getClientOriginalName());
            $user = new User;
            $user->where('email', '=', Auth::user()->email)
                 ->update(['avatar' => $request->file('avatar')->getClientOriginalName()]);
            return redirect('/home')->with('mensaje', 'Su imagen de perfil ha sido cambiada con éxito');
        }
    }

    protected function validar_contraseñas(array $data)
    {
        $mensajes=array(
            'username.required'=>'El nombre de usuario es obligatorio',
            'email.unique'=>'El correo electrónico es obligatorio',
            'password.required'=>'El campo contraseña es obligatorio',
            'password.min'=>'El campo contraseña debe tener al menos 6 caracteres',
            'password.confirmed'=>'El campo confirmación de contraseña no coincide',
            'unidad_id.required' => 'Debe seleccionar una unidad administrativa',
        );
        return \Validator::make($data, [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'unidad_id' => 'required',
        ],$mensajes);

        
    }
}
