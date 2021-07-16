<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumbrado;
use App\Bitacora_alumbrado;
use Validator;
class ReportePublicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumbrados=Alumbrado::where('estado',1)->get();

        return view('alumbrado.index',compact('alumbrados'));
    }

    public function yo_reporto()
    {
        $alumbrados=Alumbrado::where('estado',1)->get();
        return view('alumbrado.yo_reporto',compact('alumbrados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar($request->all())->validate();
        try{
            \DB::beginTransaction();
            $alumbrado= new Alumbrado();
            $alumbrado->reporto=$request->reporto;
            $alumbrado->detalle=$request->detalle;
            $alumbrado->fecha=\invertir_fecha($request->fecha);
            $alumbrado->tipo_lampara=$request->tipo_lampara;
            $alumbrado->direccion=$request->direccion;
            $alumbrado->email=$request->email;
            $alumbrado->lat=$request->lat;
            $alumbrado->lng=$request->lng;
            $alumbrado->save();

            $bitacora= new Bitacora_alumbrado();
            $bitacora->alumbrado_id=$alumbrado->id;
            $bitacora->fecha=date('Y-m-d');
            $bitacora->accion='la persona: '.$request->reporto.' reportó lámpara con desperfectos';
            $bitacora->empleado='';
            $bitacora->save();
            \DB::commit();
            return array(1,"exito",$alumbrado);
        }catch(Exception $e){
            \BD::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'reporto.required'=>'El nombre de la persona que reporta es obligatorio',
            'detalle.required'=>'El detalle de la falla es obligatorio',
            'direccion.required'=>'La dirección es obligatoria',
            'tipo_lampara.required'=>'El tipo de la lámpara es obligatoria',
            'fecha.required'=>'La fecha del reporte es obligatoria',
        );
        return Validator::make($data, [
            'reporto' => 'required',
            'detalle' => 'required',
            'direccion'=>'required',
            'tipo_lampara'=>'required',
            'fecha'=>'required',
        ],$mensajes);
    }

    protected function validar_reparar(array $data)
    {
        $mensajes=array(
            'empleado.required'=>'El nombre de la persona que reparó es obligatorio',
            //'archivo.required'=>'El nombre de la persona que reparó es obligatorio',
            'detalle.required'=>'El detalle de la falla es obligatorio',
            //'detalle_deparacion.required'=>'El tipo de la lámpara es obligatoria',
            'fecha_reparacion.required'=>'La fecha de reparación es obligatoria',
        );
        return Validator::make($data, [
            'empleado' => 'required',
            //'detalle_deparacion' => 'required',
            'fecha_reparacion'=>'required',
            //'archivo'=>'required',
        ],$mensajes);
    }
}
