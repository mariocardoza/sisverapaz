<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumbrado;
use Validator;
class AlumbradoController extends Controller
{
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
        try{
            $alumbrado=Alumbrado::create([
                'reporto'=>$request->reporto,
                'detalle'=>$request->detalle,
                'fecha'=>\invertir_fecha($request->fecha),
                'tipo_lampara'=>$request->tipo_lampara,
                'direccion'=>$request->direccion,
                'lat'=>$request->lat,
                'lng'=>$request->lng,
            ]);
            return array(1,"exito",$alumbrado);
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
}
