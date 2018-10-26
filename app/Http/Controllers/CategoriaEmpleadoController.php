<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\CategoriaTrabajo;
use App\Cargo;
use App\CategoriaEmpleado;
use App\Bitacora;

class CategoriaEmpleadoController extends Controller
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
    public function index(Request $request)
    {
        if($request->ajax())
        {
            return CategoriaEmpleado::where('estado',1)->get();
        }
        else{
            $estado = $request->get('estado');
        if($estado == "")$estado = 1;
        if($estado == 1)
        {
            $categoriaempleados = CategoriaEmpleado::where('estado', $estado)->get();
            return view('categoriaempleados.index',compact('categoriaempleados','estado'));
        }
        if($estado == 2)
        {
            $categoriaempleados = CategoriaEmpleado::where('estado',$estado)->get();
            return view('categoriaempleados.index',compact('categoriaempleados','estado'));
        }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$empleado = Empleado::findorFail($request->empleado);
        $empleados = Empleado::all();
        $categoriatrabajos = CategoriaTrabajo::all();
        $cargos = Cargo::all();
        $categoriaempleados = CategoriaEmpleado::all();
        return view('categoriaempleados.create',compact('empleados','categoriatrabajos','cargos','categoriaempleados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->All());
        CategoriaEmpleado::create([
            'cargo_id' => $request->cargo_id,
            'categoriatrabajo_id' => $request->categoriatrabajo_id,
            'empleado_id' => $request->empleado_id,
        ]);
        return redirect('categoriaempleados')->with('mensaje','Categoría registrada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoriaempleado = CategoriaEmpleado::findorFail($id);
        return view('categoriaempleados.show', compact('categoriaempleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoriaempleado = CategoriaEmpleado::findorFail($id);
        $empleados = Empleado::where('estado',1)->get();
        return view('categoriaempleados.edit', compact('categoriaempleado','empleados'));
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
        $categoriaempleado = CategoriaEmpleado::find($id);
        $categoriaempleado->fill($request->All());
        $categoriaempleado->save();
        bitacora('Modificó Categoría');
        return redirect('/categoriaempleados')->with('mensaje','Registro modificado');
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
        $datos = explode("+", $cadena);
        $id = $datos[0];
        $motivo = $datos[1];

        $categoriaempleado = CategoriaEmpleado::find($id);
        $categoriaempleado->estado = 2;
        $categoriaempleado->motivo = $motivo;
        $categoriaempleado->save();
        bitacora('Dió de baja Categoría');
        return redirect('/categoriaempleados')->with('mensaje','Categoría dado de baja');
    }

    public function alta($id)
    {
        $categoriaempleado = CategoriaEmpleado::find($id);
        $categoriaempleado->estado = 1;
        $categoriaempleado->motivo = "";
        $categoriaempleado->save();
        Bitacora:bitacora('Dió de alta un Categoría');

        return redirect('/categoriaempleados')->with('mensaje', 'Categoría dado de alta');
    }
}
