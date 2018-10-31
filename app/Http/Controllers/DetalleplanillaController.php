<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalleplanilla;
use App\Empleado;
use DB;
use App\Http\Requests\DetalleplanillaRequest;

class DetalleplanillaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $empleados= Empleado::with('detalleplanilla')->where('estado',1)->where('detalleplanilla.id','>',0)->get();
      $empleados = Detalleplanilla::empleadosPlanilla();
      return view('detalleplanillas.index',compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('detalleplanillas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetalleplanillaRequest $request)
    {
        $detalle=Detalleplanilla::create($request->All());
        return redirect('detalleplanillas')->with('mensaje','Detalle de planilla registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalle= Detalleplanilla::find($id);
        return view('detalleplanillas.show',compact('detalle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $detalle= Detalleplanilla::find($id);
      return view('detalleplanillas.edit',compact('detalle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DetalleplanillaRequest $request, $id)
    {
      $detalle= Detalleplanilla::find($id);
      $detalle->salario=$request->salario;
      $detalle->tipo_pago=$request->tipo_pago;
      $detalle->pago=$request->pago;
      $detalle->save();
      return redirect('detalleplanillas')->with('mensaje','Registro modificado con éxito');
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
