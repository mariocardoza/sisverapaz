<?php

namespace App\Http\Controllers;
use App\Vacacion;

use Illuminate\Http\Request;

class VacacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!isset($request->estado)){
            $estado=0;
        }else{
            $estado=$request->estado;
        }
        $vacaciones=Vacacion::where('estado',$estado)->orderBy('created_at')->get();
        return view('vacaciones.index',compact('vacaciones','estado'));
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
        //
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
    public static function fecha(Request $request){
        

        if($request->ajax())
      {
        try{
            $vacacion=Vacacion::find($request->id_vacacion);
            $vacacion->estado=2;
            $vacacion->fecha_vacacion=$request->fecha_vacacion;
            $vacacion->fecha_pago=$request->fecha_pago;
            $vacacion->pago=$request->pago;
            $vacacion->save();
          return array(1,'exito');
        }catch(\Exception $e){
          return array(-1,$e);
        }
      }


    }
}

