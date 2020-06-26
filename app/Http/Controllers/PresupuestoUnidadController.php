<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Presupuestounidad;
use App\Presupuestounidaddetalle;
use App\MaterialUnidad;
use DB;

class PresupuestoUnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        Auth()->user()->authorizeRoles(['admin','uaci']);
        $anios=DB::table('presupuestounidads')->distinct()->get(['anio']);
        $elanio="";
        if($request->get('anio') == ""){
            $elanio=date("Y");
        }else{
            $elanio=$request->get('anio');
        } 
        $elestado=$request->get('estado');
        if($elestado=="" || $elestado > 4){
            $presupuestos = Presupuestounidad::where('anio','>=',$elanio)->whereIn('estado',[1,3])->get();
            return view('unidades.presupuestos.index',compact('presupuestos','anios'));
        
        }
        if($elestado==1){
            $presupuestos = Presupuestounidad::where('anio','>=',$elanio)->whereIn('estado',[1,3])->get();
            return view('unidades.presupuestos.index',compact('presupuestos','anios'));
        }
        if($elestado==2){
            $presupuestos = Presupuestounidad::where('estado',2)->where('anio','>=',$elanio)->get();
            return view('unidades.presupuestos.index',compact('presupuestos','anios'));
        }
        if($elestado==4){
            $presupuestos = Presupuestounidad::where('estado',4)->where('anio','>=',$elanio)->get();
            return view('unidades.presupuestos.index',compact('presupuestos','anios'));
        }
        
    }

    public function porunidad(Request $request)
    {
        $anios=DB::table('presupuestounidads')->distinct()->get(['anio']);
        $elanio=$request->get('anio');
        if($elanio != ""){
            $presupuestos = Presupuestounidad::where('user_id',Auth()->user()->id)->whereIn('estado',[1,3,4])->where('anio',$elanio)->get();
            return view('unidades.presupuestos.porunidad',compact('presupuestos','anios','elanio'));
        }else{
            $elanio=0;
        }
        $elestado=$request->get('estado');
        if($elestado=="" || $elestado > 4){
            $presupuestos = Presupuestounidad::where('user_id',Auth()->user()->id)->whereIn('estado',[1,3])->where('anio',date("Y"))->get();
            return view('unidades.presupuestos.porunidad',compact('presupuestos','anios','elanio'));
        }
        if($elestado==1){
            $presupuestos = Presupuestounidad::where('user_id',Auth()->user()->id)->whereIn('estado',[1,3])->where('anio',date("Y"))->get();
            return view('unidades.presupuestos.porunidad',compact('presupuestos','anios','elanio'));
        }
        if($elestado==2){
            $presupuestos = Presupuestounidad::where('user_id',Auth()->user()->id)->where('estado',2)->where('anio',date("Y"))->get();
            return view('unidades.presupuestos.porunidad',compact('presupuestos','anios','elanio'));
        }
        if($elestado==4){
            $presupuestos = Presupuestounidad::where('user_id',Auth()->user()->id)->where('estado',4)->where('anio',date("Y"))->get();
            return view('unidades.presupuestos.porunidad',compact('presupuestos','anios','elanio'));
        }
        
        
    }

    public function clonar($id)
    {
        $presupuesto=Presupuestounidad::find($id);
        $prenuevo=Presupuestounidad::create([
            'unidad_id' => $presupuesto->unidad_id,
            'anio' => date("Y"),
            'user_id'=>$presupuesto->user_id
        ]);
        $detaa=$mate=[];
        try{
            DB::beginTransaction();
            foreach($presupuesto->presupuestodetalle as $deta){
                $materiales=MaterialUnidad::where('presupuestounidad_id',$deta->id)->get();
                $detaa[]=$deta;
                $detanuevo=Presupuestounidaddetalle::create([
                    'presupuestounidad_id'=>$prenuevo->id,
                    'cantidad'=>$deta->cantidad,
                    'precio'=>$deta->precio,
                    'material_id'=>$deta->material_id
                ]);
                foreach($materiales as $material){
                    $mate[]=$material;
                    $matenuevo=MaterialUnidad::create([
                        'id'=>MaterialUnidad::retornar_id(),
                        'material_id'=>$material->material_id,
                        'presupuestounidad_id'=>$detanuevo->id,
                    ]);
                }
            }
            DB::commit();
            return array(1,"exito",$detaa,$mate);
        }catch(Exception $e){
            DB::rollback();
        }
    }

    public function cambiar(Request $request,$id)
    {
        try{
            $presupuesto=Presupuestounidad::find($id);
            $presupuesto->estado=$request->estado;
            $presupuesto->save();
            return array(1,"exito",$presupuesto);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = Unidad::where('estado',1)->get();
        return view('unidades.presupuestos.create',compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try{
        $presupuestounidad = Presupuestounidad::create([
            'unidad_id' => $request->unidad_admin,
            'anio' => $request->anio,
            'user_id'=>Auth()->user()->id
        ]);
        
        return array(1,"exito",$presupuestounidad->id);
       }catch(Exception $e){
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
        $presupuesto = Presupuestounidad::findorFail($id);
        return view('unidades.presupuestos.show',compact('presupuesto'));
    }

    public function show2($id)
    {
        $retorno=Presupuestounidad::show($id);
        return $retorno;
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

    public function materiales($id)
    {
      $retorno=Presupuestounidad::materiales($id);
      return $retorno;
    }

    public function anio(Request $request,$anio)
    {
        if($anio>0){
            $presu=Presupuestounidad::where('anio',$anio)->whereIn('estado',[1,3])->where('unidad_id',$request->unidad_id)->get();
            
        }
        return $presu;
    }
}
