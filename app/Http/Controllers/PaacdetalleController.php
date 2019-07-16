<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paac;
use App\Paacdetalle;
use DB;

class PaacdetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try{
          $paacdetalle=Paacdetalle::create([
            'id'=>Paacdetalle::retornar_id(),
            'obra'=>$request->obra,
            'paac_id'=>$request->paac_id,
            'enero'=>$request->enero,
            'febrero'=>$request->febrero,
            'marzo'=>$request->marzo,
            'abril'=>$request->abril,
            'mayo'=>$request->mayo,
            'junio'=>$request->junio,
            'julio'=>$request->julio,
            'agosto'=>$request->agosto,
            'septiembre'=>$request->septiembre,
            'octubre'=>$request->octubre,
            'noviembre'=>$request->noviembre,
            'diciembre'=>$request->diciembre,
            'subtotal'=>$request->subtotal
          ]);
          $paac=Paac::find($request->paac_id);
          $total=floatval($paac->total);
          $total=$total+floatval($request->subtotal);
          $paac->total=$total;
          $paac->save();
          return array(1,"exito");
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
      $retorno=Paac::editar($id);
      return $retorno;
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
        $detalle = Paacdetalle::findorFail($id);
        $total=$request->enero+$request->febrero+$request->marzo+$request->abril+$request->mayo+$request->junio+$request->julio+$request->agosto+$request->septiembre+$request->octubre+$request->noviembre+$request->diciembre;
        $detalle->fill($request->All());
        $detalle->subtotal=$total;
        $detalle->save();

        $detalles = Paacdetalle::where('paac_id',$detalle->paac_id)->get();
        $totalito=0;
        foreach($detalles as $valor){
          $totalito=$totalito+$valor->subtotal;
        }
        $paac = Paac::findorFail($detalle->paac_id);
        $paac->total=$totalito;
        $paac->save();
        DB::commit();
        return array(1,"exito");
      }catch (\Exception $e){
        DB::rollback();
        return array(1,'error',$e->getMessage());
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
        $detalle = Paacdetalle::findorFail($id);
        $paac = Paac::findorFail($detalle->paac_id);
        $total=$paac->total;
        $paac->total=$total-$detalle->subtotal;
        $paac->save();
        $detalle->delete();
        return array(1,"exito");
    }
}
