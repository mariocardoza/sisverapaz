<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presupuesto;
use App\Presupuestodetalle;
use Session;
use DB;

class PresupuestoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function guardarsesion(Request $request)
     {
       $presupuestos = Session::get('presupuestos');
       $si=false;

         if(count($presupuestos) > 0)
         {
           for($i=0; $i< count($presupuestos);$i++) {
               if($presupuestos[$i]['catalogo_id'] == $request->catalogo && $presupuestos[$i]['existe'] == true){
                 return Response()->json([
                   'mensaje' => 'error'
                 ]);
                 $si=true;
               }
           }
         }else{
           $presupuesto = [
             'existe' => true,
             'catalogo_id' => intval($request->catalogo),
             'descripcion' => $request->descripcion,
             'cantidad' => intval($request->cantidad),
             'precio' => floatval($request->precio),
             'unidad' => $request->unidad,
           ];

           Session::push('presupuestos', $presupuesto);
           return Response()->json([
             'mensaje' => 'si'
           ]);
         }

         if($si){
           return Response()->json([
             'mensaje' => 'error',
           ]);
         }else{
           $presupuesto = [
             'existe' => true,
             'catalogo_id' => intval($request->catalogo),
             'descripcion' => $request->descripcion,
             'cantidad' => intval($request->cantidad),
             'precio' => floatval($request->precio),
             'unidad' => $request->unidad,
           ];

           Session::push('presupuestos', $presupuesto);
           return Response()->json([
             'mensaje' => 'si',
           ]);
         }

     }

     public function traersesion()
     {
       $s1=Session::get('presupuestos');
       $s2=Session::get('presupuestosbase');
       if(count($s1) > 0 && count($s2) > 0){
         $presupuesto = array_merge($s1, $s2);
       }else{
         if(count($s1) == 0 ){
           $presupuesto=$s2;
         }else{
           if(count($s2) == 0){
             $presupuesto=$s1;
           }else{
             $presupuesto=null;
           }
         }
       }
         return response($presupuesto);
     }

     public function limpiarsesion()
     {
       Session::forget('presupuestos');
       //Session::forget('presupuestosbase');
       return Response()->json([
         'mensaje' => 'limpiado',
       ]);
     }

     public function eliminarsesion($id)
     {
       if(isset($id))
       {
         $presupuestos = Session::get('presupuestos');
         $presupuestosbase = Session::get('presupuestosbase');

         try{
           for($i=0; $i< count($presupuestos);$i++) {
               if($presupuestos[$i]['catalogo_id'] == $id && $presupuestos[$i]['existe'] == true){

                 $presupuestos[$i]['existe']=false;
               }
               Session::put('presupuestos', $presupuestos);
           }

           for($i=0; $i< count($presupuestosbase);$i++) {
               if($presupuestosbase[$i]['catalogo_id'] == $id && $presupuestosbase[$i]['existe'] == true){
                 //Session::forget('fondosbase.'.$i);
                 $presupuestosbase[$i]['existe']=false;
                 $presupuesto=Presupuestodetalle::where('catalogo_id',$id)->first();
                 $presupuesto->delete();
               }
               Session::put('presupuestosbase',$presupuestosbase);
           }

           return response()->json([
               'mensaje' => 'borrado',
               'datos' => Session::get('presupuestos'),
               'base' => Session::get('presupuestosbase')
             ]);
         }catch(\Exception $e){
           return response()->json([
               'mensaje' => $e->getMessage(),
             ]);
         }
       }
     }

    public function index()
    {
        //
    }

    public function getCatalogo(Request $request)
    {
      $idp=$request->idp;
      $categorias = DB::table('catalogos')
                ->where('categoria_id',$request->idc)
                ->whereNotExists(function ($query) use ($idp) {
                     $query->from('presupuestodetalles')
                        ->whereRaw('presupuestodetalles.catalogo_id = catalogos.id')
                        ->whereRaw('presupuestodetalles.presupuesto_id ='.$idp);
                    })->get();
      return response($categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
      $presupuesto=Presupuesto::findorFail($id);
      Session::forget('presupuestosbase');
      foreach($presupuesto->presupuestodetalle as $detalle){
        $presupuestos = [
          'existe' => true,
          'catalogo_id' => intval($detalle->catalogo_id),
          'descripcion' => str_replace ( " " , "_" ,$detalle->catalogo->nombre),
          'cantidad' => intval($detalle->cantidad),
          'precio' => floatval($detalle->preciou),
          'unidad' => $detalle->catalogo->unidad_medida,
        ];
        Session::push('presupuestosbase',$presupuestos);
      }
      //dd(Session::get('presupuestosbase'));
      return view('presupuestos.detalle.create', compact('presupuesto'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax())
        {
          $presupuestos = Session::get('presupuestos');
          $presupuestosbase = Session::get('presupuestosbase');
          DB::beginTransaction();
          try{
            $presupuesto=Presupuesto::findorFail($request->presupuesto_id);
            $presupuesto->total=$presupuesto->total+$request->total;
            $presupuesto->save();

            for($i=0; $i< count($presupuestos);$i++) {
              if($presupuestos[$i]['existe']==true){
                $detallenuevo=new Presupuestodetalle();
                $detallenuevo->presupuesto_id = $request->presupuesto_id;
                $detallenuevo->cantidad = $presupuestos[$i]['cantidad'];
                $detallenuevo->preciou = $presupuestos[$i]['precio'];
                $detallenuevo->catalogo_id = $presupuestos[$i]['catalogo_id'];
                $detallenuevo->save();
              }
            }

              DB::commit();
              Session::forget('presupuestos');
              Session::forget('presupuestosbase');
            return response()->json([
              'mensaje' => 'exito',
              'id' => $request->presupuesto_id
            ]);
          }catch(\Exception $e){
              DB::rollback();
            return response()->json([
              'mensaje' => $e->getMessage()
            ]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detalle=Presupuestodetalle::findorFail($id);
        return view('presupuestos.detalle.edit',compact('detalle'));
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
      DB::beginTransaction();
        try{
          $detalle=Presupuestodetalle::findorFail($id);
          $detalle->fill($request->all());
          $detalle->save();
          $presupuesto=Presupuesto::findorFail($detalle->presupuesto->id);
          $detalles=Presupuestodetalle::where('presupuesto_id',$presupuesto->id)->get();
          $total=0.0;
          foreach($detalles as $de){
            $total=$total+$de->cantidad*$de->preciou;
          }
          $presupuesto->total=$total;
          $presupuesto->save();
          DB::commit();
          return redirect('presupuestos/'.$presupuesto->id)->with('mensaje','Elemento modificado exitosamente');
        }catch(\Exception $e){
          DB::rollback();
          return redirect('presupuestos/'.$presupuesto->id)->with('error','Ocurrió un error, contacte al administrador');
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
      DB::beginTransaction();
      try{
        $detalle=Presupuestodetalle::findorFail($id);
        $detalle->delete();
        $presupuesto=Presupuesto::findorFail($detalle->presupuesto->id);
        $detalles=Presupuestodetalle::where('presupuesto_id',$presupuesto->id)->get();
        $total=0.0;
        foreach($detalles as $de){
          $total=$total+$de->cantidad*$de->preciou;
        }
        $presupuesto->total=$total;
        $presupuesto->save();
        DB::commit();
        return redirect('presupuestos/'.$presupuesto->id)->with('mensaje','Elemento eliminado exitosamente');
      }catch(\Exception $e){
        DB::rollback();
        return redirect('presupuestos/'.$presupuesto->id)->with('error','Ocurrió un error, contacte al administrador');

      }
    }
}
