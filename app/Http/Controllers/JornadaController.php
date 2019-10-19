<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\PeriodoProyecto;
use Validator;

class JornadaController extends Controller
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
        $this->validar($request->all())->validate();
        $pendientes=PeriodoProyecto::pendientes($request->proyecto_id);
        if(count($pendientes)==0){
            try{
                $jornada=PeriodoProyecto::create([
                    'id'=>date('Yidisus'),
                    'proyecto_id'=>$request->proyecto_id,
                    'fecha_inicio'=>invertir_fecha($request->fecha_inicio),
                    'fecha_fin'=>invertir_fecha($request->fecha_fin)
                ]);
                return array(1,"exito",$jornada);
            }catch(Exception $e){
                return array(-1,"error",$e->getMessage());
            }
        }else{
            return array(-2,"error","Tiene una catorcena pendiente");
        }
        
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'fecha_inicio.required'=>'La fecha de inicio es obligatoria',
            'fecha_fin.required'=>'La fecha de finalización es obligatoria'
        );
        return Validator::make($data, [
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
        ],$mensajes);

        
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
}
