<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Especialista;
use App\Bitacora;

class EspecialistaController extends Controller
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
        $especialistas = Especialista::all();
        return view('especialistas.index',compact('especialistas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $especialistas = Especialista::all();
        return view('especialistas.create',compact('especialistas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Especialista::create($request->All());
        return redirect('especialistas')->with('mensaje','Especialista registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $especialista = Especialista::findorFail($id);
        return view('especialistas.show',compact('especialistas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $especialista = Especialista::find($id);
        return view('especialistas.edit',compact('especialista'));
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
        $especialista = Especialista::find($id);
        $especialista->find($request->All());
        $especialista->save();
        bitacora('Modificó un registro');
        return redirect('/especialistas')->with('mensaje','Registro modificado con éxito');
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
        $especialista = Especialista::find($id);
        $especialista->estado = 2;
        $especialista->motivo = $motivo;
        $especialista->fechabaja = date('Y-m-d');
        $especialista->save();
        bitacora('Dió de baja especialista');
        return redirect('/especialistas')->with('mensaje','Registro dado de baja');
    }

    public function alta($id)
    {
        $especialista = Especialista::find($id);
        $especialista->estado = 1;
        $especialista->motivo = null;
        $especialista->fecha_baja = null;
        $especialista->save();
        Bitacora::bitacora('Dió de alta un registro');
        return redirect('/especialista')->with('mensaje','Especialista dado de alta');
    }
}
