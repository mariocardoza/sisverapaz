<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Empleado;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller

//trait RegistersUsers

{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;
    use RedirectsUsers;

    public function showRegistrationForm()
    {
      $roles = Role::all();
        return view('auth.register',compact('roles'));
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function register(Request $request)
    {
        dd($request->All()); 
       $this->validator($request->all())->validate();

       $empleado = Empleado::create([
            'nombre' => $request->nombre,
            'dui' => $request->dui,
            'nit' => $request->nit,
            'sexo' => $request->sexo,
            'email'=>$request->email,
            'telefono_fijo' => $request->telefono_fijo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => invertir_fecha($request->fecha_nacimiento),
       ]);

       //event(new Registered($user = $this->create($request->all())));

       event(new Registered($user = $this->create([
        'empleado_id' => $empleado->id,
        'username' => $request->username,
        'email' => $request->email,
        'password' => $request->password,
       ])));

       $user
       ->roles()
       ->attach(Role::find($request->role));

       $this->guard()->login($user);

       return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());

        /*event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());*/
        //dd($request->All());
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => 'required|string|max:255',
            'dui' => 'required|unique:empleados',
            'nit' => 'required|unique:empleados',
            'sexo' => 'required',
            'telefono_fijo' => 'required|unique:empleados',
            'celular' => 'required|unique:empleados',
            'direccion' => 'required',
            'fecha_nacimiento' => 'required',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'cargo' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        //dd($data);
        return User::create([
            'empleado_id' => $data['empleado_id'],
            'username' => $data['username'],
            'email' => $data['email'],
            'cargo' => $data['cargo'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        //
    }
}
