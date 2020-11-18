<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\Tipocontrato;
use App\CategoriaEmpleado;
use App\Bitacora;
use App\Http\Requests\EmpleadoRequest;
use Validator;
use App\Role;
use DB;
use App\Http\Requests\UsuariosRequest;
use App\User;
use Auth;
use App\Cargo;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectcargo($id)
    {
        $retorno=Cargo::selectcargo($id);
        return $retorno;
    }
    public function index(Request $request)
    {
        Auth()->user()->authorizeRoles(['admin','tesoreria']);
        $roles = Role::all();
        $losbancos=\App\Banco::where('estado',1)->get();
        $lasafps=\App\afp::where('estado',1)->get();
        $bancos=$afps=[];
        foreach ($losbancos as $banco) {
            $bancos[$banco->id]=$banco->nombre;
        }
        foreach ($lasafps as $afp) {
            $afps[$afp->codigo]=$afp->nombre;
        }
        if($request->ajax())
        {
            return Empleado::where('nombre','<>','Administrador')->where('estado',1)->orderBy('nombre','ASC')->get();
        }
        else{
            $estado = $request->get('estado');
        if($estado == "" )$estado = 1;
        if($estado == 1)
        {
            $empleados = Empleado::where('nombre','<>','Administrador')->where('estado',$estado)->orderBy('nombre','ASC')->get();
            return view('empleados.index',compact('empleados','estado','bancos','afps','roles'));
        }
        if($estado == 2)
        {
            $empleados = Empleado::where('nombre','<>','Administrador')->where('estado',$estado)->orderBy('nombre','ASC')->get();
            return view('empleados.index',compact('empleados','estado','bancos','afps'));
        }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth()->user()->authorizeRoles(['admin','tesoreria']);
        $tipocontratos = Tipocontrato::where('estado',1);
        return view('empleados.create',compact('tipocontratos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpleadoRequest $request)
    {
     //dd($request->All()); 
      if($request->ajax())
      {
        try{
          $empleado=Empleado::create([
            'nombre' => $request->nombre,
            'dui' => $request->dui,
            'nit' => $request->nit,
            'sexo' => $request->sexo,
            'email'=>$request->email,
            'telefono_fijo' => $request->telefono_fijo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'es_usuario'=>$request->es_usuario,
            'fecha_nacimiento' => invertir_fecha($request->fecha_nacimiento),
            'num_contribuyente' => $request->num_contribuyente,
            'num_seguro_social' => $request->num_seguro_social,
            'num_afp' => $request->num_afp,
          ]);
         
          return array(1,"exito",$empleado);
        }catch(\Exception $e)
        {
          return array(-1,"error",$e->getMessage());
        }
      }else{
        try{
          Empleado::create([
            'nombre' => $request->nombre,
            'dui' => $request->dui,
            'nit' => $request->nit,
            'sexo' => $request->sexo,
            'telefono_fijo' => $request->telefono_fijo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'es_usuario'=>$request->es_usuario,
            'fecha_nacimiento' => invertir_fecha($request->fecha_nacimiento)
          ]);
          return redirect('/empleados')->with('mensaje', 'Empleado registrado exitosamente');
        }catch(\Exception $e){
          return redirect('empleados/create')->with('error','Ocurrió un error, contacte al administrador');
        }
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
       //Auth()->user()->authorizeRoles(['admin','tesoreria']);
        //$roles = Role::all();
        $losroles=Role::all();
        $empleados = DB::table('empleados')->where('es_usuario','=','si')
                    ->whereNotExists(function ($query)  {
                         $query->from('users')
                            ->whereRaw('empleados.id = users.empleado_id');
                        })->get();
        $empleado = Empleado::findorFail($id);
        $losbancos=\App\Banco::where('estado',1)->get();
        $lasafps=\App\afp::where('estado',1)->get();
        $bancos=$afps=[];
        foreach ($losbancos as $banco) {
            $bancos[$banco->id]=$banco->nombre;
        }

        foreach ($lasafps as $afp) {
            $afps[$afp->codigo]=$afp->nombre;
        }

        foreach ($losroles as $rol) {
            $roles[$rol->id]=$rol->description;
        }

        $listaempleados=\App\Empleado::where('estado',1)->where('id',$id)->orderBy('nombre','ASC')->get();
        //dd($listaempleados);
          $empleados= [];
          foreach($listaempleados as $e){
            //if($e->detalleplanilla->count()>0){
              $empleados[$e->id]=$e->nombre;
           // }
          }

        return view('empleados.show', compact('empleado','bancos','afps','roles','empleados'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado = Empleado::findorFail($id);
        return view('empleados.edit',compact('empleado'));
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
        try{
           $empleado = Empleado::find($id);
            $empleado->fill($request->All());
            $empleado->save();
            bitacora('Modificó un registro'); 
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $empleado=Empleado::find($id);
            $empleado->estado=2;
            $empleado->save();

            $usuario=User::where('empleado_id',$empleado->id)->first();
            $usuario->estado=2;
            $usuario->save();
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }

    }

    public function usuarios(UsuariosRequest $request){
        try{
            $user = User::create([
            'empleado_id' => $request['elempleado'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $user
        ->roles()
        ->attach(Role::find($request->roles));

        bitacora('Registró un usuario');
        return array(1,"exito");
    }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
    }

    }

    public function eusuarios(Request $request){
        try{
            if($request->contra_actual==''):
                //$this->validar_usuarios($request->all())->validate();
                $empleado=Empleado::find($request->elempleado);
                $usuario=$empleado->user;
                if($usuario->username!= $request->username)
                {
                    $this->validate($request,['username'=> 'required|unique:users|min:5']);
                }
                $usuario->username=$request->username;
                if($usuario->email!= $request->email){
                    $this->validate($request,['email'=> 'required|unique:users|email']);
                }
                $usuario->email=$request->email;
                $empleado->email=$request->email;
                $empleado->save();
                $usuario->save();
            else:
                $request->validate([
                    'contra_actual' => ['required', new MatchOldPassword],
                    'password' => ['required'],
                    'confirm_password' => ['same:password'],
                ]);
                $empleado=Empleado::find($request->elempleado);
                $usuario=$empleado->user;
                if($usuario->username!= $request->username)
                {
                    $this->validate($request,['username'=> 'required|unique:users|min:5']);
                }
                $usuario->username=$request->username;
                if($usuario->email!= $request->email){
                    $this->validate($request,['email'=> 'required|unique:users|email']);
                }
                $usuario->email=$request->email;
                $empleado->email=$request->email;
                $empleado->save();
                $usuario->save();
                $empleado=Empleado::find($request->elempleado);
                User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
            endif;
            return array(1,"exito",$empleado);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function bancarios(Request $request){
        $this->validar_bancarios($request->all())->validate();
        try{
            $empleado=Empleado::find($request->codigo);
            $empleado->banco_id=$request->banco;
            $empleado->num_cuenta=$request->num_cuenta;
            $empleado->save();
            return array(1,"exito",$empleado);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function afps(Request $request){
        $this->validar_afps($request->all())->validate();
        try{
            $empleado=Empleado::find($request->codigo);
            $empleado->afp_codigo=$request->afp;
            $empleado->num_afp=$request->num_afp;
            $empleado->save();
            return array(1,"exito",$empleado);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function isss(Request $request){
        $this->validar_isss($request->all())->validate();
        try{
            $empleado=Empleado::find($request->codigo);
            $empleado->num_seguro_social=$request->num_seguro_social;
            $empleado->save();
            return array(1,"exito",$empleado);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function foto(Request $request,$id)
    {
      try{
        $empleado = Empleado::find($id);
        /*if($empleado->user->avatar!=$request->file('foto')->getClientOriginalName()){
          if($empleado->user->avatar!='avatar.jpg'){
            unlink('avatars/'.$empleado->user->avatar);
          }
        }*/
        $archivo="avatar_user_".date("Y-m-d-h-i-s-a").".".$request->file('foto')->getClientOriginalExtension();
        $request->file('foto')->storeAs('public/avatars', $archivo);
        //$request->file('foto')->move('avatars', $request->file('foto')->getClientOriginalName());
        $empleado->avatar=$archivo;
        $empleado->save();
         Auth()->user()->empleado->avatar=$empleado->avatar;
        return back()->with('mensaje','Imagen cambiada con exito');
      }catch(Exception $e){
        return back()->with('error','Ocurrió un error al subir la imagen');
      }
      
    }

    protected function validar_usuarios(array $data)
    {
        $mensajes=array(
            'username.required'=>'El número de cuenta es obligatorio',
            //'username.unique'=>'El nombre de usuario ya esta en uso'
        );
        return Validator::make($data, [
            'username' => 'required',
        ],$mensajes);

        
    }

    protected function validar_usuarios_contra(array $data)
    {
        $mensajes=array(
            'username.required'=>'El nombre de usuario es obligatorio',
           // 'email.unique'=>'El correo electrónico es obligatorio',
            'password.required'=>'El campo contraseña es obligatorio',
            'password.min'=>'El campo contraseña debe tener al menos 6 caracteres',
            'password.confirmed'=>'El campo confirmación de contraseña no coincide',
        );
        return \Validator::make($data, [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|string|min:6|confirmed',
           
        ],$mensajes);

        
    }

    protected function validar_bancarios(array $data)
    {
        $mensajes=array(
            'num_cuenta.required'=>'El número de cuenta es obligatorio',
            'num_cuenta.unique'=>'El número de cuenta ya esta en uso'
        );
        return Validator::make($data, [
            'num_cuenta' => 'required|unique:empleados',
        ],$mensajes);

        
    }

     protected function validar_isss(array $data)
    {
        $mensajes=array(
            'num_seguro_social.required'=>'El número de isss es obligatorio',
            'num_seguro_social.unique'=>'El número de isss ya esta en uso'
        );
        return Validator::make($data, [
            'num_seguro_social' => 'required|unique:empleados',
        ],$mensajes);

        
    }

     protected function validar_afps(array $data)
    {
        $mensajes=array(
            'num_afp.required'=>'El número de afp es obligatorio',
            'num_afp.unique'=>'El número de afp ya esta en uso'
        );
        return Validator::make($data, [
            'num_afp' => 'required|unique:empleados',
        ],$mensajes);

        
    }

    public function baja($cadena)
    {
        $datos = explode("+", $cadena);
        $id = $datos[0];
        $motivo = $datos[1];
        $unidad = Empleado::find($id);
        //$unidad->motivo = $motivo;
        //$unidad->fecha_baja = date('Y-m-d');
        $unidad->estado = 2;
        $unidad->save();
        bitacora('Dió de baja la unidad administrativa');
        return redirect('/empleados')->with('mensaje','Registro dada de baja');
    }
    public function alta($id)
    {
        $unidad = Empleado::find($id);
        $unidad->estado = 1;
        //$unidad->motivo = null;
        //$unidad->fecha_baja = null;
        $unidad->save();
        bitacora('Dió de alta a un registro');
        return redirect('/empleados')->with('mensaje','Registro dado de alta');
    }

    public function perfil($id)
    {
       //Auth()->user()->authorizeRoles(['admin','tesoreria']);
        //$roles = Role::all();
        $losroles=Role::all();
        $empleados = DB::table('empleados')->where('es_usuario','=','si')
                    ->whereNotExists(function ($query)  {
                         $query->from('users')
                            ->whereRaw('empleados.id = users.empleado_id');
                        })->get();
        $empleado = Empleado::findorFail($id);
        $losbancos=\App\Banco::where('estado',1)->get();
        $lasafps=\App\afp::where('estado',1)->get();
        $bancos=$afps=[];
        foreach ($losbancos as $banco) {
            $bancos[$banco->id]=$banco->nombre;
        }

        foreach ($lasafps as $afp) {
            $afps[$afp->codigo]=$afp->nombre;
        }

        foreach ($losroles as $rol) {
            $roles[$rol->id]=$rol->description;
        }

        $listaempleados=\App\Empleado::where('estado',1)->where('id',$id)->orderBy('nombre','ASC')->get();
        //dd($listaempleados);
          $empleados= [];
          foreach($listaempleados as $e){
            //if($e->detalleplanilla->count()>0){
              $empleados[$e->id]=$e->nombre;
           // }
          }

        return view('empleados.perfil', compact('empleado','bancos','afps','roles','empleados'));
    }
}
