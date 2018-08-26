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
    public function index()
    {
        $categoriaempleados = CategoriaEmpleado::all();
        //dd($categoriaempleados);
        return view('categoriaempleados.index',compact('categoriaempleados'));
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
        CategoriaEmpleado::create($request->All());
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
        return view('categoriaempleados.edit', compact('categoriaempleado'));
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
        //
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
}
