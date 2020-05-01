<?php

namespace App\Http\Controllers;

use App\Inmueble;
use Illuminate\Http\Request;
use Validator;

class InmuebleController extends Controller
{

    public function removeTipoServicioInmueble(Request $request)
    {
        $parameters = $request->all();
        $inmueble = Inmueble::find($parameters['id']);
        if($inmueble->tipoServicio()->detach($parameters['idTipoServicio'])){
            return array(
                'response' => true,
                'message'  => 'La peticion fue realizada con exito'
            );
        }else{
            return array(
                'response' => false,
                'message'  => 'Tenemos un problema con el servidor por el momento, intenta mas tarde.'
            );
        }
    }
    public function addTipoServicioInmueble(Request $request)
    {
        $parameters = $request->all();
        
        $inmueble = Inmueble::find($parameters['id']);
        $tipoServicio = \App\TipoServicio::find($parameters['idTipoServicio']);

        if($inmueble->tipoServicio->contains($tipoServicio)){
            return array(
                'response' => false,
                'message' => 'Lo sentimos pero no puedes agregar dos veces el mismo impuesto'
            );
        }else{
            $inmueble->tipoServicio()->save($tipoServicio);
            return array(
                'response' => true,
                'data'     => $tipoServicio,
                'message'  => 'Hemos agregado con exito el impuesto a este inmueble.'
            );
        }
    }
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all  = $request->all();
        $contribuyente = \App\Contribuyente::find($all['contribuyente']);
        
        $inmueble    = new Inmueble();
        $inmueble->estado = 1;
        $inmueble->latitude            = $all['object']['latitude'];
        $inmueble->longitude           = $all['object']['longitude'];
        $inmueble->metros_acera        = $all['object']['metros_acera'];
        $inmueble->ancho_inmueble      = $all['object']['ancho_inmueble'];
        $inmueble->largo_inmueble      = $all['object']['largo_inmueble'];
        $inmueble->numero_escritura    = $all['object']['numero_escritura'];
        $inmueble->numero_catastral    = $all['object']['numero_catastral'];
        $inmueble->direccion_inmueble  = $all['object']['direccion_inmueble'];
        $inmueble->contribuyente_id    = $all['contribuyente'];
        $isTrueOrFalse = $contribuyente->inmuebles()->save($inmueble);

        if($isTrueOrFalse) {
          return array(
            'response' => true,
            "inmueble" => $inmueble
          );
        }else{
          return array(
            'response' => false,
            'message' => 'Lo sentimos pero no puedes agregar dos veces el inmueble'
          );
        }
    }

    public function guardar(Request $request)
    {
        $this->validar($request->all())->validate();
        try{
            $inmueble    = new Inmueble();
            $inmueble->estado = 1;
            $inmueble->latitude            = $request['lat'];
            $inmueble->longitude           = $request['lng'];
            $inmueble->metros_acera        = $request['metros_acera'];
            $inmueble->ancho_inmueble      = $request['ancho_inmueble'];
            $inmueble->largo_inmueble      = $request['largo_inmueble'];
            $inmueble->numero_escritura    = $request['numero_escritura'];
            $inmueble->numero_catastral    = $request['numero_catastral'];
            $inmueble->direccion_inmueble  = $request['direccion_inmueble'];
            $inmueble->contribuyente_id    = $request['contribuyente_id'];
            $inmueble->save();
            return array(1,"exito",$inmueble);
        }catch(Exception $e){
            return array(-1,"error",$e->getMEssage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function show(Inmueble $inmueble)
    {
        return $inmueble->load(['tipoServicio']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function edit(Inmueble $inmueble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inmueble $inmueble)
    {
      $all = $request->all();

      $inmueble->metros_acera = $all['object']['metros_acera'];
      $inmueble->medida_inmueble = $all['object']['medida_inmueble'];
      $inmueble->numero_catastral = $all['object']['numero_catastral'];
      $inmueble->numero_escritura = $all['object']['numero_escritura'];
      $inmueble->direccion_inmueble = $all['object']['direccion_inmueble'];
      
      if($inmueble->save()) {
          return array(
            'response' => true,
            "inmueble" => $inmueble
          );
        }else{
          return array(
            'response' => false,
            'message' => 'Lo sentimos pero no puedes agregar dos veces el mismo impuesto'
          );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $inmueble = Inmueble::find($id)->update([
            'estado' => intval($request->get('estado'))
        ]);
        return "{ 'message' : 'Todo esta correcto' }";
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'ancho_inmueble.required'=>'El ancho del inmueble obligatorio',
            'largo_inmueble.required'=>'El largo del inmueble obligatorio',
            'numero_escritura.required'=>'El número de la escritura del inmueble obligatorio',
            'unidad_id.required'=>'La unidad de medida es obligatoria',
            'categoria_id.required'=>'La categoría es obligatoria',
        );
        return Validator::make($data, [
            'contribuyente_id' => 'required',
            'numero_catastral' => 'required',
            'ancho_inmueble'=>'required|numeric',
            'largo_inmueble'=>'required|numeric',
            'numero_escritura'=>'required',
            'metros_acera'=>'required|numeric',
        ],$mensajes);
    }
}
