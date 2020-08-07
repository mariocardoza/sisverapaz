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
        if($request->ajax()){
            try{
            //$detalle=Detalleplanilla::create($request->All());
            $detalle=new Detalleplanilla();
            $detalle->empleado_id=$request->empleado_id;
            $detalle->salario=$request->salario;
            $detalle->tipo_pago=$request->tipo_pago;
            $detalle->pago=$request->pago;
            $detalle->unidad_id=$request->unidad_id;
            $detalle->numero_acuerdo=$request->numero_acuerdo;
            $detalle->cargo_id=$request->cargo_id;
            $detalle->fecha_inicio=invertir_fecha($request->fecha_inicio);
            $detalle->save();
            return array(1,"exito");
           }catch(Excection $e){
            return array(-1,"error",$e->getMessage());
           }
        }else{
            $detalle=Detalleplanilla::create($request->All());
            return redirect('detalleplanillas')->with('mensaje','Detalle de planilla registrado');
        }
        
    }

    public function store2(Request $request)
    {
        if($request->ajax()){
            try{
            //$detalle=Detalleplanilla::create($request->All());
            $detalle=new Detalleplanilla();
            $detalle->empleado_id=$request->empleado_id;
            $detalle->salario=$request->salario;
            $detalle->tipo_pago=$request->tipo_pago;
            $detalle->pago=$request->pago;
            $detalle->numero_acuerdo=$request->numero_acuerdo;
            $detalle->cargoproyecto_id=$request->cargoproyecto_id;
            $detalle->proyecto_id=$request->proyecto_id;
            $detalle->fecha_inicio=$request->fecha_inicio;
            $detalle->save();
            return array(1,"exito");
           }catch(Excection $e){
            return array(-1,"error",$e->getMessage());
           }
        }else{
            $detalle=Detalleplanilla::create($request->All());
            return redirect('detalleplanillas')->with('mensaje','Detalle de planilla registrado');
        }
        
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
      $detalle->unidad_id=$request->unidad_id;
      $detalle->numero_acuerdo=$request->numero_acuerdo;
      $detalle->cargo_id=$request->cargo_id;
      $detalle->fecha_inicio=invertir_fecha($request->fecha_inicio);
      $detalle->save();
      if($request->ajax()){
          return array(1,"exito",$request->all());
      }else{
        return redirect('detalleplanillas')->with('mensaje','Registro modificado con éxito');
      }
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
