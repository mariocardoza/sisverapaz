<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\Retencion;
use App\Contrato;
use App\Planilla;
use App\Detalleplanilla;
use App\Datoplanilla;
use DB;
use App\Prestamo;

class PlanillaController extends Controller
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

    public function index()
    {
        $planillas = Datoplanilla::orderBy('created_at',"desc")->orderBy('estado',"asc")->get();
        return view('planillas.index',compact('planillas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mes = date('m');
        $year = date('Y');
        // $empleados = Contrato::all();
        // $retencion = Retencion::first();
        $retenciones = Retencion::all();
        $empleados= Detalleplanilla::empleadosPlanilla();
        return view('planillas.create',compact('mes','year','empleados','retenciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existe=Datoplanilla::where('mes',$request->mes)->where('anio',$request->anio)->whereIn('estado',[1,3,4])->count();
        if($existe==0){
            $retenciones = Retencion::all();
            $count = count($request->empleado_id);
            try {
                DB::beginTransaction();
                $datoplanilla=Datoplanilla::create([
                    'fecha'=>\Carbon\Carbon::now(),
                    'tipo_pago'=>$request->tipo,
                    'mes'=>$request->mes,
                    'anio'=>$request->anio
                ]);
                for($i=0;$i<$count;$i++){
                    if($request->prestamos[$i]=='0'){
                        $p=null;
                    }else{
                        $p=$request->prestamos[$i];
                    }
                    if($request->descuentos[$i]=='0'){
                        $d=null;
                    }else{
                        $d=$request->descuentos[$i];
                    }
                    Planilla::create([
                        'empleado_id'=>$request->empleado_id[$i],
                        'issse'=>$request->ISSSE[$i],
                        'afpe'=>$request->AFPE[$i],
                        'isssp'=>$request->ISSSP[$i],
                        'afpp'=>$request->AFPP[$i],
                        'insaforpp'=>$request->INSAFORPP[$i],
                        'estado'=>0,
                        'datoplanilla_id'=>$datoplanilla->id,
                        'prestamos'=>$p,
                        'descuentos'=>$d,
                        'renta'=>$request->renta[$i],
                    ]);
                }
                //Prestamo::actualizar();
                DB::commit();
                return redirect('/planillas')->with('mensaje', 'Planilla registrada exitosamente');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect('planillas')->with('error','Ocurrió un error, contacte al administrador');
            }
        }else{
            if($existe == 1 && $request->tipo==2){
                $retenciones = Retencion::all();
                $count = count($request->empleado_id);
                try {
                    DB::beginTransaction();
                    $datoplanilla=Datoplanilla::create([
                        'fecha'=>\Carbon\Carbon::now(),
                        'tipo_pago'=>$request->tipo,
                        'mes'=>$request->mes,
                        'anio'=>$request->anio
                    ]);
                    for($i=0;$i<$count;$i++){
                        if($request->prestamos[$i]=='0'){
                            $p=null;
                        }else{
                            $p=$request->prestamos[$i];
                        }
                        if($request->descuentos[$i]=='0'){
                            $d=null;
                        }else{
                            $d=$request->descuentos[$i];
                        }
                        Planilla::create([
                            'empleado_id'=>$request->empleado_id[$i],
                            'issse'=>$request->ISSSE[$i],
                            'afpe'=>$request->AFPE[$i],
                            'isssp'=>$request->ISSSP[$i],
                            'afpp'=>$request->AFPP[$i],
                            'insaforpp'=>$request->INSAFORPP[$i],
                            'estado'=>0,
                            'datoplanilla_id'=>$datoplanilla->id,
                            'prestamos'=>$p,
                            'descuentos'=>$d,
                            'renta'=>$request->renta[$i],
                        ]);
                    }
                    //Prestamo::actualizar();
                    DB::commit();
                    return redirect('/planillas')->with('mensaje', 'Planilla registrada exitosamente');
                }catch (\Exception $e) {
                    DB::rollback();
                    return redirect('planillas')->with('error','Ocurrió un error, contacte al administrador');
                }
            }else{
                    return redirect('planillas')->with('error','Ya existe la planilla registrada para el mes de '.Datoplanilla::obtenerMes($request->mes).' del año '.$request->anio);
            }
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
        $datoplanilla=Datoplanilla::find($id);
        $planillas=Planilla::where('datoplanilla_id',$id)->get();
        return view('planillas.show',compact('planillas','datoplanilla'));
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
        try{
            $planilla=Datoplanilla::find($id);
            $planilla->estado=3;
            $planilla->save();
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try{
            $planilla=Datoplanilla::find($id);
            $planilla->estado=2;
            $planilla->motivo=$request->motivo;
            $planilla->save();
            return array(1,"exito",$request->all());
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }
}
