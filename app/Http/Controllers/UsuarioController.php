<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Bitacora;
use App\Contrato;
use App\Role;
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
                $usuarios = User::where('estado',$estado)->get();
                return view('usuarios.index',compact('usuarios','estado'));
            }
            if ($estado == 2) {
                $usuarios = User::where('estado',$estado)->get();
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
      $contratos=Contrato::where('estado',1)->get();
      return view('usuarios.create',compact('contratos','roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuariosRequest $request)
    {
        $user = User::create([
            'empleado_id' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $user
        ->roles()
        ->attach(Role::find($request->roles));

        bitacora('Registro un usuario');
        return redirect('usuarios')->with('mensaje','Usuario almacenado con éxito');
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
        $usuario = User::find($id);
        //dd($cargos);
        return view('usuarios.edit',compact('usuario'));
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
        $usuario = User::find($id);
        $usuario->fill($request->All());
        bitacora('Usuario '.$request['name'].' modificado');
        $usuario->save();


        return redirect('usuarios')->with('mensaje','Usuario '.$request['name'] .' modificado con éxito');
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

    public function baja($cadena)
    {
        //dd($id);
        //dd(Auth()->user()->cargo);
        $datos = explode("+", $cadena);
        $id=$datos[0];
        $motivo=$datos[1];
        $usuarios = User::find($id);
        $idusuario=$usuarios->cargo;
        //dd($idusuario);
        if(Auth()->user()->cargo == $idusuario){
            return redirect('usuarios')->with('error','No se puede eliminar al administrador');
        }else{
            $usuarios->estado=2;
            $usuarios->motivo=$motivo;
            $usuarios->fechabaja=date('Y-m-d');
            $usuarios->save();
            bitacora('Dió de baja a un usuario');
            return redirect('/usuarios')->with('mensaje','Usuario dado de baja');
        }

    }

    public function alta($id)
    {

        //$datos = explode("+", $cadena);
        ////$id=$datos[0];
        //$motivo=$datos[1];
        //dd($id);
        $usuarios = User::find($id);
        $usuarios->estado=1;
        $usuarios->motivo=null;
        $usuarios->fechabaja=null;
        $usuarios->save();
        Bitacora::bitacora('Dió de alta a un usuario');
        return redirect('/usuarios')->with('mensaje','Usuario dado de alta');
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
}
