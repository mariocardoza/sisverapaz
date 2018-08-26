<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitudcotizacion;
use App\Bitacora;
use App\Categoria;
use App\Http\Requests\SolicitudRequest;
use App\Formapago;
use App\Proyecto;
use App\Unidad;
use App\Presupuesto;
use App\Presupuestodetalle;
use App\PresupuestoSolicitud;
use App\Requisicione;
use DB;
use Validator;

class SolicitudcotizacionController extends Controller
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

    public function index(Request $request)
    {
      $estado = $request->get('estado');
      if($estado=="" || $estado==1){
        $estado=1;
        $solicitudes = Solicitudcotizacion::all();
        return view('solicitudcotizaciones.index',compact('solicitudes','estado'));
      }else if($estado==2){
        $solicitudes = PresupuestoSolicitud::with('presupuesto')->where('estado',$estado)->get();
        return view('solicitudcotizaciones.index',compact('solicitudes','estado'));
      }else if($estado==3){
        $solicitudes = PresupuestoSolicitud::with('presupuesto')->where('estado',$estado)->get();
        return view('solicitudcotizaciones.index',compact('solicitudes','estado'));
      }
    }

    public function getPresupuesto(Request $request)
    {
        $proyecto=Proyecto::findorFail($request->idp);
        $presupuesto = Presupuesto::where('proyecto_id',$proyecto->id)->where('categoria_id',$request->idc)->with('presupuestodetalle')->first();
        return Presupuestodetalle::where('presupuesto_id',$presupuesto->id)->with('catalogo')->get();
    }

    public function getCategorias(Request $request)
    {
      $proyecto=Proyecto::findorFail($request->idc);
      return $presupuesto=Presupuesto::where('proyecto_id',$proyecto->id)->where('estado',1)->with('categoria')->get();
    }

    public function versolicitudes($id)
    {
      $proyecto=Proyecto::findorFail($id);
      return view('solicitudcotizaciones.porproyecto',compact('proyecto'));
    }


      public function cambiar(Request $request)
      {
          if($request->ajax()){
              try{
                  $proyecto=Proyecto::findorFail($request->idp);
                  $proyecto->estado=5;
                  $proyecto->save();

                  $solicitud=PresupuestoSolicitud::findorFail($request->idps);
                  $solicitud->estado=2;
                  $solicitud->save();
                  return response()->json([
                      'mensaje' => 'exito'
                  ]);
              }catch(\Exception $e){
                  return response()->json([
                  'mensaje' => $e
                  ]);
              }

          }
      }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
      $proyecto = Proyecto::findorFail($id);
      $formapagos = Formapago::all();
      $unidades = Unidad::all();
      return view('solicitudcotizaciones.create',compact('formapagos','proyecto','unidades'));
    }

    public function creater($id)
    {
      $requisicion = Requisicione::findorFail($id);
      $formapagos = Formapago::all();
      return view('solicitudcotizaciones.creater',compact('formapagos','requisicion','unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitudRequest $request)
    {
        //dd($request->All());
        if($request->ajax())
        {
          DB::beginTransaction();
          try{
            $presupuesto = Presupuesto::where('categoria_id',$request->categoria)->where('proyecto_id',$request->proyecto)->first();

            $pre=PresupuestoSolicitud::create([
              'presupuesto_id' => $presupuesto->id,
              'categoria_id' => $request->categoria,
            ]);

            $solicitud=Solicitudcotizacion::create([
                "formapago_id" => $request->formapago,
                "unidad" => $request->unidad,
                "encargado" => $request->encargado,
                "cargo_encargado" => $request->cargo,
                "lugar_entrega" => $request->lugar_entrega,
                "numero_solicitud" => Solicitudcotizacion::correlativo(),
                'fecha_limite' => invertir_fecha($request->fecha_limite),
                'tiempo_entrega' => $request->tiempo_entrega,
                'tipo' => 1,
                'solicitud_id' => $pre->id,
            ]);

            $presupuesto->estado=2;
            $presupuesto->save();

            $presuu=Presupuesto::where('estado',1)->count();
            if($presuu==0){
              $proyecto=Proyecto::findorFail($request->proyecto);
              $proyecto->estado=4;
              $proyecto->save();
              DB::commit();
              return response()->json([
                'mensaje' => 'exito',
                'proyecto' => $proyecto->id
              ]);
            }
            DB::commit();
            return response()->json([
              'mensaje' => 'proyectos',
            ]);
          }catch(\Exception $e){
            DB::rollback();
            return response($e->getMessage());
          }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storer(Request $request)
    {
      if($request->ajax())
      {
        DB::beginTransaction();
          try{
            $solicitud=Solicitudcotizacion::create([
                "formapago_id" => $request->formapago,
                "unidad" => $request->unidad,
                "encargado" => $request->encargado,
                "cargo_encargado" => $request->cargo,
                "lugar_entrega" => $request->lugar_entrega,
                "numero_solicitud" => Solicitudcotizacion::correlativo(),
                'fecha_limite' => invertir_fecha($request->fecha_limite),
                'tiempo_entrega' => $request->tiempo_entrega,
                'tipo' => 2,
                'requisicion_id' => $request->requisicion,
            ]);

            $requisicion=Requisicione::findorFail($request->requisicion);
            $requisicion->estado=3;
            $requisicion->save();
            DB::commit();
          }catch(\Exception $e){
            DB::rollback();
            return response()->json([
              'messaje' => 'error',
              'error' => $e->getMessage()
            ]);
          }


          return response()->json([
            'requisicion' => $solicitud->id,
            'mensaje' => 'exito'
          ]);
      }
    }
    public function show($id)
    {
      $solicitud=PresupuestoSolicitud::findorFail($id);
      $presupuesto = Presupuesto::where('categoria_id', $solicitud->categoria_id)->firstorFail();
        return view('solicitudcotizaciones.show',compact('solicitud','presupuesto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $solicitud = Solicitudcotizacion::findorFail($id);
        $formapagos = Formapago::all();
        $unidades = Unidad::all();
        $proyectos = Proyecto::where('estado',1)->where('presupuesto',true)->get();
        return view('solicitudcotizaciones.edit',compact('solicitud','formapagos','unidades','proyectos'));
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
