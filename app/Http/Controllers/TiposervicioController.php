<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipocontratoRequest;
use Illuminate\Http\Request;
use App\Tiposervicio;
use App\Http\Requests\TiposervicioRequest;

class TipoServicioController extends Controller
{
    public function index()
    {
        return TipoServicio::select('id', 'nombre', 'costo', 'estado', 'isObligatorio')->get();
    }

    public function show(TipoServicio $tipoServicio)
    {
        return $tipoServicio;
    }

    /* Nuevo Servicio */
    public function store(Request $request)
    {
      $tipo  = new Tiposervicio();
      $params = $request->all();

      $tipo->estado = 1;
      $tipo->nombre = $params['data']['nombre'];
      $tipo->costo  = $params['data']['costo'];
      $tipo->isObligatorio = 0;

      if($tipo->save()){
        return array(
          "response"  => true,
          "data"      => $tipo,
          "message"   => 'Hemos agregado con exito al nuevo servicio',
        );
      }else{
        return array(
          "response"  => false,
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
        );
      }
    }

    /* Editar Servicio */
    public function update(Request $request, $id)
    {
      $params = $request->all();
      $tipo = Tiposervicio::find($id);

      $tipo->nombre   = $params['data']['nombre'];
      $tipo->costo    = $params['data']['costo'];
      
      if($tipo->save()) {
        return array(
          "message"   => 'Hemos actualizado con exito la informacion',
          "data"      => Tiposervicio::find($id),
          "ok"        => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }

    public function destroy($id, Request $request)
    {
      $params = $request->all();
      $tipo = Tiposervicio::find($id);
      $tipo->estado = $params['estado'] == 'true' ? 1 : 0;
      
      if($tipo->save()) {
        return array(
          "message"         => 'Hemos actualizado con exito el estado',
          "ok"  => true
        );
      }else{
        return array(
          "message"         => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }
}

