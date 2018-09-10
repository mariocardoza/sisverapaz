<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CargoRequest;
use App\Cargo;
use Carbon\Carbon;
use App\Bitacora;

class CargoController extends Controller
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

    public function get()
    {
      $cargos = Cargo::get();
      return response()->json([

         'cargos'    => $cargos,

     ], 200);
    }

    public function index(Request $request)
    {
        $estado = $request->get('estado');
        if($estado == "")$estado = 1;
        if($estado == 1)
        {
            $cargos = Cargo::where('estado', $estado)->get();
            return view('cargos.index',compact('cargos','estado'));
        }
        if($estado == 2)
        {
            $cargos = Cargo::where('estado',$estado)->get();
            return view('cargos.index',compact('cargos','estado'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CargoRequest $request)
    {
        Cargo::create($request->All());
        return redirect('cargos')->with('mensaje', 'Cargo registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cargo = Cargo::findorFail($id);
        return view('cargos.show',compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cargo = Cargo::findorFail($id);
        return view('cargos.edit',compact('cargo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CargoRequest $request, $id)
    {
        $cargo = Cargo::find($id);
        $cargo->fill($request->All());
        $cargo->save();
        bitacora('Modificó Cargo');
        return redirect('/cargos')->with('mensaje','Registro modificado');
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

        $cargo = Cargo::find($id);
        $cargo->estado = 2;
        $cargo->motivo = $motivo;
        $cargo->save();
        bitacora('Dió de baja cargo');
        return redirect('/cargos')->with('mensaje','Cargo dado de baja');
    }

    public function alta($id)
    {
        $cargo = Cargo::find($id);
        $cargo->estado = 1;
        $cargo->motivo = "";
        $cargo->save();
        Bitacora:bitacora('Dió de alta un cargo');

        return redirect('/cargos')->with('mensaje', 'Cargo dado de alta');
    }
}
