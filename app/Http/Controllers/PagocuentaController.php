<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagoCuenta;
use Validator;

class PagocuentaController extends Controller
{
    public function index($id)
    {
        $catorcena=\App\PeriodoProyecto::find($id);
        $pagos=PagoCuenta::where('estado',1)->where('catorcena_id',$id)->orderby('created_at')->get();
        return view('pagocuentas.index',compact('pagos','catorcena'));
    }

    function create()
    {
    	return view('pagocuentas.create');
    }

    public function store(Request $request)
    {
    	$this->validar($request->all())->validate();
    	PagoCuenta::create([
    		'nombre' => $request->nombre
    	]);

    	return array(1,"éxito");
    }

    protected function validar(array $data)
    {
    	return Validator::make($data, ['nombre' => 'required|unique|:pagocuentas',
    	]);
    }

    public function edit($id)
    {
    	$pagocuenta = PagoCuenta::find($id);

    	return array(1,"exitoso",$pagocuenta);
    }

    public function update(Request $request, $id)
    {
    	$pagocuenta = PagoCuenta::find($id);
    	if($pagocuenta->nombre!= $request->nombre){
    		$this->validate($request,['nombre' => 'required|unique:pagocuentas|min:5']);
    	}

    	$pagocuenta->nombre = $request->nombre;
    	$pagocuenta->save();
    	return array(1,"éxito");
    }

    public function baja($cadena)
    {
    	$datos = explode("+",$cadena);
    	$id = $datos[0];
    	$pagocuenta = PagoCuenta::find($id);
    	$pagocuenta->estado = 2;
    	$pagocuenta->save();
    	bitacora('Registro dado de baja');
    	return redirect('/pagocuentas')->with('mensaje','Registro dado de baja');
    }

    public function alta($id)
    {
    	$pagocuenta = PagoCuenta::find($id);
    	$pagocuenta->estado = 1;
    	$pagocuenta->save();
    	bitacora('Registro dado de alta');
    	return redirect('/pagocuentas')->with('mensaje','Registro dado de alta');
    }
}
