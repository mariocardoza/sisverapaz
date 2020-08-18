<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\SolicitudRequisicion;
use Validator;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudes=SolicitudRequisicion::all();
        $combinadas=DB::table('requisiciondetalles as rd')
        ->select('m.nombre','c.nombre_categoria as cnombre','m.codigo','rd.materiale_id as elid','m.categoria_id','um.nombre_medida',DB::raw('SUM(rd.cantidad) AS suma'))
        ->join('materiales as m','m.id','=','rd.materiale_id','inner')
        ->join('unidad_medidas as um','um.id','=','rd.unidad_medida','inner')
        ->join('requisiciones as r','r.id','=','rd.requisicion_id')
        ->join('categorias as c','c.id','=','m.categoria_id')
        ->where('r.estado','=',9)
        ->groupBy('m.id','rd.unidad_medida')
        ->get();
        return view('solicitudes.index',compact('combinadas','solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $solicitud=SolicitudRequisicion::find($id);
        $combinadas=DB::table('requisiciondetalles as rd')
        ->select('m.nombre','c.nombre_categoria as cnombre','m.codigo','rd.materiale_id as elid','m.categoria_id','um.nombre_medida',DB::raw('SUM(rd.cantidad) AS suma'))
        ->join('materiales as m','m.id','=','rd.materiale_id','inner')
        ->join('unidad_medidas as um','um.id','=','rd.unidad_medida','inner')
        ->join('requisiciones as r','r.id','=','rd.requisicion_id')
        ->join('categorias as c','c.id','=','m.categoria_id')
        ->where('r.estado','=',9)
        ->where('r.solirequi_id','=',$id)
        ->groupBy('m.id','rd.unidad_medida')
        ->get();
        return view('solicitudes.show',compact('solicitud','combinadas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function solicitud($id)
    {
        $retorno=\App\Solicitudcotizacion::solicitud($id);
        return $retorno;
    }

    public function informacion($id)
    {
        $retorno=SolicitudRequisicion::informacion($id);
        return $retorno;
    }

    public function formulariosoli($id)
    {
        $retorno=SolicitudRequisicion::formulario_solicitud($id);
        return $retorno;
    }

    public function aprobar(Request $request){
        $this->validar_aprobar($request->all())->validate();
        try{
          $requisicion=SolicitudRequisicion::find($request->requisicion_id);
          $requisicion->cuenta_id=$request->cuenta_id;
          $requisicion->estado=3;
          $requisicion->save();
          return array(1,"exito");
        }catch(Exception $e){
          return array(1,"error",$e->getMessage());
        }
      }

      public function cambiarestado(Request $request,$id){
        $requisicion=SolicitudRequisicion::find($id);
        try{
          $requisicion->estado=$request->estado;
          if(isset($request->fecha_acta)):
            $requisicion->fecha_acta=date("Y-m-d H:i:s");
          endif;
          $requisicion->save();
          return array(1,"exito");
        }catch(Exception $e){
          return array(-1,"error",$e->getMessage());
        }
      }
  

      protected function validar_aprobar(array $data)
    {
        $mensajes=array(
            'cuenta_id.required'=>'Seleccione una cuenta para aprobar la requisición',
        );
        return Validator::make($data, [
            'cuenta_id' => 'required',

        ],$mensajes);

        
    }
}
