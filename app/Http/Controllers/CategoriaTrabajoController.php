<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaTrabajo;
use App\Bitacora;

class CategoriaTrabajoController extends Controller
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
            return CategoriaTrabajo::where('estado',1)->get();
        }
        else{
            $estado = $request->get('estado');
            if($estado == "")$estado = 1;
            if($estado == 1)
            {
                $categoriatrabajos = CategoriaTrabajo::where('estado', $estado)->get();
                return view('categoriatrabajos.index',compact('categoriatrabajos','estado'));
            }
            if($estado == 2)
            {
                $categoriatrabajos = CategoriaTrabajo::where('estado',$estado)->get();
                return view('categoriatrabajos.index',compact('categoriatrabajos','estado'));
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
        $categoriatrabajos = CategoriaTrabajo::all();
        return view('categoriatrabajos.create', compact('categoriatrabajos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CategoriaTrabajo::create($request->All());
        return redirect('categoriatrabajos')->with('mensaje','Categoría registrada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoriatrabajo = CategoriaTrabajo::findorFail($id);
        return view('categoriatrabajos.show', compact('categoriatrabajo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoriatrabajo = CategoriaTrabajo::findorFail($id);
        return view('categoriatrabajos.edit', compact('categoriatrabajo'));
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
        $categoriatrabajo = CategoriaTrabajo::find($id);
        $categoriatrabajo->fill($request->All());
        $categoriatrabajo->save();
        bitacora('Modificó Categoría');
        return redirect('/categoriatrabajos')->with('mensaje','Registro modificado');
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

        $categoriatrabajo = CategoriaTrabajo::find($id);
        $categoriatrabajo->estado = 2;
        $categoriatrabajo->motivo = $motivo;
        $categoriatrabajo->save();
        bitacora('Dió de baja Categoría');
        return redirect('/categoriatrabajos')->with('mensaje','Categoría dado de baja');
    }

    public function alta($id)
    {
        $categoriatrabajo = CategoriaTrabajo::find($id);
        $categoriatrabajo->estado = 1;
        $categoriatrabajo->motivo = "";
        $categoriatrabajo->save();
        Bitacora:bitacora('Dió de alta un Categoría');

        return redirect('/categoriatrabajos')->with('mensaje', 'Categoría dado de alta');
    }
}
