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
        $planillas = Datoplanilla::all();
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
        $retenciones = Retencion::all();
        $count = count($request->empleado_id);
        try {
            DB::beginTransaction();
            $datoplanilla=Datoplanilla::create([
                'fecha'=>\Carbon\Carbon::now(),
                'tipo_pago'=>$request->tipo,
            ]);
            for($i=0;$i<$count;$i++){
                if($request->prestamos[$i]=='0'){
                    $p=null;
                }else{
                    $p=$request->prestamos[$i];
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
                    'prestamo_id'=>$p,
                    'renta'=>$request->renta[$i],
                ]);
            }
            Prestamo::actualizar();
            DB::commit();
            return redirect('/planillas')->with('mensaje', 'Planilla registrada exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
          return redirect('planillas')->with('error','Ocurrió un error, contacte al administrador');
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
        $planillas=Planilla::where('datoplanilla_id',$id)->get();
        return view('planillas.show',compact('planillas'));
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
}
