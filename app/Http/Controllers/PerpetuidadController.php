<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cementerio;
use App\Contribuyente;
use App\Perpetuidad;
use App\PerpetuidadBeneficiario;

class PerpetuidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulos=Perpetuidad::all();
        return view('perpetuidad.index',compact('titulos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cementerios=Cementerio::all();
        $contribuyentes=Contribuyente::whereEstado(1)->get();
        return view('perpetuidad.create',compact('cementerios','contribuyentes'));
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
            $t=Perpetuidad::create($request->all());
            return array(1,"exito",$t);

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
    public function show(Perpetuidad $perpetuidad)
    {
        return view('perpetuidad.show',\compact('perpetuidad'));
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

    public function beneficiario(Request $request)
    {
        try{
            $cuantos=PerpetuidadBeneficiario::where('perpetuidad_id',$request->perpetuidad_id)->whereEstado(1)->count();
            if($cuantos<=2){
                PerpetuidadBeneficiario::create([
                    'perpetuidad_id'=>$request->perpetuidad_id,
                    'beneficiario'=>$request->beneficiario,
                    'fecha_entierro'=>\invertir_fecha($request->fecha_entierro)
                ]);
                return array(1);
            }else{
                return array(2,'No se pueden sepultar mas de dos personas en el mismo nicho');
            }
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }
}
