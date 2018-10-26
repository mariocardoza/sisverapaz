<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuentaproy;
use App\Cuenta;
use App\Proyecto;
use App\Http\Requests\CuentaRequest;
use App\Http\Requests\CuentauRequest;

class CuentaController extends Controller
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
        $cuentas = Cuentaproy::all();
        return view('cuentas.index',compact('cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$proyectos=Proyecto::all();
        return view('cuentas.create',compact('proyectos'));*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CuentaRequest $request)
    {
        Cuentaproy::create($request->All());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuenta = Cuenta::findorFail($id);
        return view('cuentas.show',compact('cuenta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuenta = Cuenta::findorFail($id);
        return view('cuentas.edit',compact('cuenta'));
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
        //dd($request->All());
        $cuenta->fill($request->All());
        $cuenta->save();
        return redirect('cuentas')->with('mensaje','Cuenta modificada con éxito');
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

        $cuenta = Cuenta::find($id);
        $cuenta->estado = 2;
        $cuenta->motivo = $motivo;
        $cuenta->save();
        bitacora('Dió de baja una cuenta');
        return redirect('/cuentas')->with('mensaje', 'Cuenta dada de baja');
    }

    public function alta($id)
    {
        $cuenta = Cuenta::find($id);
        $cuenta->estado = 1;
        $cuenta->motivo = "";
        $cuenta->save();
        bitacora('Dió de alta una cuenta');
        return redirect('/cuentas')->with('mensaje', 'Cuenta dada de alta');
    }
}
