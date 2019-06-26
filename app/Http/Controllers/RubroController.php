<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rubro;
use App\Bitacora;
use App\Http\Requests\RubroRequest;
use App\Carbon;

class RubroController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        return Rubro::All();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rubros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rubro  = new Rubro();
      $params = $request->all();

      $rubro->estado = 1;
      $rubro->nombre = $params['data']['nombre'];
      $rubro->porcentaje = $params['data']['porcentaje'];

      if($rubro->save()){
        return array(
          "response"  => true,
          "data"      => $rubro,
          "message"   => 'Hemos agregado con exito al nuevo rubro',
        );
      }else{
        return array(
          "response"  => false,
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
        );
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rubro $rubro)
    {
        //$rubro = Rubro::findorFail($id);
        return view('rubros.edit',compact('rubro'));
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
      $params = $request->all();
      $rubro = Rubro::find($id);
      $rubro->nombre      = $params['data']['nombre'];
      $rubro->porcentaje  = $params['data']['porcentaje'];
      
      if($rubro->save()) {
        return array(
          "message"   => 'Hemos actualizado con exito la informacion',
          "data"      => Rubro::find($id),
          "ok"        => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
      $params = $request->all();
      $rubro = Rubro::find($id);
      $rubro->estado = $params['estado'] == 'true' ? 1 : 0;
      
      if($rubro->save()) {
        return array(
          "message"   => 'Hemos actualizado con exito el estado',
          "ok"  => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }

    public function baja($cadena)
    {

        $datos = explode("+", $cadena);
        $id=$datos[0];
        $motivo=$datos[1];
        //dd($id);
        $rubro = Rubro::find($id);
        $rubro->estado=2;
        $rubro->motivo=$motivo;
        $rubro->fechabaja=date('Y-m-d');
        $rubro->save();
        bitacora('Dió de baja a un rubro');
        return redirect('/rubros')->with('mensaje','Rubro dado de baja');
    }

    public function alta($id)
    {

        //$datos = explode("+", $cadena);
        ////$id=$datos[0];
        //$motivo=$datos[1];
        //dd($id);
        $rubro = Rubro::find($id);
        $rubro->estado=1;
        $rubro->motivo=null;
        $rubro->fechabaja=null;
        $rubro->save();
        Bitacora::bitacora('Dió de alta a un rubro');
        return redirect('/rubros')->with('mensaje','Proyecto dado de alta');
    }

    public function GetApiController () {
        return Rubro::all();
    }
}