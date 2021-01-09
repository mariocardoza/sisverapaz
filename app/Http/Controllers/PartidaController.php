<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partida;
use App\Contribuyente;

class PartidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partidas=Partida::all();
        $contribuyentes=Contribuyente::whereEstado(1)->get();
        return view('partidas.index',compact('partidas','contribuyentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'contribuyente' => 'required|max:100',
            'monto' => 'required|numeric|min:0.00',
        ]);

        try{
            $partida=Partida::create([
                'contribuyente'=>$request->contribuyente,
                'monto'=>$request->monto,
                'fiestas'=>\retornar_porcentaje('fiestas'),
                'total'=>$request->monto+($request->monto*retornar_porcentaje('fiestas')),
                'tipo'=>1,
            ]);
            return array(1,"exito",$partida);
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
        $partida=Partida::findorFail($id);
        return array(1,"exito",$partida);
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
        $partida=Partida::findorFail($id);
        $partida->contribuyente=$request->contribuyente;
        $partida->monto=$request->monto;
        $partida->total=$request->monto+($request->monto*retornar_porcentaje('fiestas'));
        $partida->save();
        return array(1,"exito",$partida);
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

    public function pago(Request $request)
    {
        $partida=Partida::findorFail($request->id);
        $partida->estado=3;
        $partida->fecha_pago=date("Y-m-d");
        $partida->save();
        return array(1,"exito",$partida);
    }
}
