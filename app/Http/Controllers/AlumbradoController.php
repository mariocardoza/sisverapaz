<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumbrado;
use App\Bitacora_alumbrado;
use Validator;
class AlumbradoController extends Controller
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
        $alumbrados=Alumbrado::where('estado',1)->get();

        return view('alumbrado.index',compact('alumbrados'));
    }

    public function reparadas()
    {
        $alumbrados=Alumbrado::where('estado',3)->get();

        return view('alumbrado.reparadas',compact('alumbrados'));
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
            $alumbrado=Alumbrado::create([
                'reporto'=>$request->reporto,
                'detalle'=>$request->detalle,
                'fecha'=>\invertir_fecha($request->fecha),
                'tipo_lampara'=>$request->tipo_lampara,
                'direccion'=>$request->direccion,
                'lat'=>$request->lat,
                'lng'=>$request->lng,
            ]);

            $bitacora=Bitacora_alumbrado::create([
                'alumbrado_id'=>$alumbrado->id,
                'fecha'=>date('Y-m-d'),
                'accion'=>'la persona: '.$request->reporto.' reportó lámpara con desperfectos',
                'empleado'=>''
            ]);
            \DB::commit();
            return array(1,"exito",$alumbrado);
        }catch(Exception $e){
            \BD::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }

    public function reparar(Request $request)
    {
        $this->validar_reparar($request->all())->validate();
        try{

            $acta="";
            if($request->archivo):
            $request->file('archivo')->storeAs('alumbrados/actas', $request->file('archivo')->getClientOriginalName());
            $acta=$request->file('archivo')->getClientOriginalName();
            endif;
            \DB::beginTransaction();
            $a=Alumbrado::find($request->id);
            $a->fecha_reparacion=invertir_fecha($request->fecha_reparacion);
            $a->detalle_reparacion=$request->detalle_reparacion;
            $a->acta=$acta;
            $a->estado=3;
            $a->save();

            $bitacora=Bitacora_alumbrado::create([
                'alumbrado_id'=>$a->id,
                'fecha'=>date('Y-m-d'),
                'accion'=>'la persona: '.$request->empleado.' reparó la lámpara',
                'empleado'=>$request->empleado
            ]);
            \DB::commit();
            return array(1);
        }catch(Exception $e){
            \DB::rollback();
            return array(-1,"error",$e->getMessage());
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
        $lampara=Alumbrado::find($id);
        return view('alumbrado.show',compact('lampara'));
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
