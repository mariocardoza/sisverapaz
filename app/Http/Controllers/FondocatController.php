<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fondocat;
use App\Bitacora;

class FondocatController extends Controller
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
        $fondocats = Fondocat::all();
        return view('fondocats.index', compact('fondocats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fondocats = Fondocat::all();
        return view('fondocats.create', compact('fondocats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Fondocat::create($request->All());
        return redirect('fondocats')->with('mensaje', 'Fondo registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fondocat = Fondocat::findorFail($id);
        return view('fondocats.show', compact('fondocat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fondocat = Fondocat::findorFail($id);
        return view('fondocats.edit', compact('fondocat'));
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
        $fondocat = Fondocat::find($id);
        $fondocat->fill($request->All());
        $fondocat->save();
        bitacora('Modificó un registro');
        return redirect('fondocats')->with('mensaje', 'Registro modificado con éxito');
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
        try{
            $datos = explode("+",$cadena);
            $id = $datos[0];
            $motivo = $datos[1];

            $fondocat = Fondocat::find($id);
            $fondocat->estado = 2;
            $fondocat->motivo = $motivo;
            $fondocat->fechabaja = date('Y-m-d');
            $fondocat->save();
            bitacora('Dió de baja categoría de fondos');
            return redirect('/fondocats')->with('mensaje', 'Categoría dada de baja');
        }catch(\Exception $e){
            return redirect('/fondocats')->with('mensaje', 'Error, no se puede dar de baja');
        }
    }

    public function alta($id)
    {
        $fondocat = Fondocat::find($id);
        $fondocat->estado = 1;
        $fondocat->motivo = null;
        $fondocat->fechabaja = null;
        $fondocat->save();
        Bitacora::bitacora('Dió de alta un fondo de categoría');
        return redirect('/fondocats')->with('mensaje', 'Categoría dada de alta');
    }
}
