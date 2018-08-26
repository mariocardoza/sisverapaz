<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formapago;
use App\Bitacora;
use App\Http\Requests\FormapagoRequest;

class FormapagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if($request->ajax())
        {
          $formapagos=Formapago::where('estado',1)->get();
          return response($formapagos);
        }else{
          $estado = $request->get('estado');
          if($estado == "" )$estado=1;
          if ($estado == 1) {
              $formapagos = Formapago::where('estado',$estado)->get();
              return view('formapagos.index',compact('formapagos','estado'));
          }
          if ($estado == 2) {
              $formapagos = Formapago::where('estado',$estado)->get();
              return view('formapagos.index',compact('formapagos','estado'));
          }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formapagos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormapagoRequest $request)
    {
        if($request->ajax()){
          try{
            Formapago::create($request->All());
            bitacora('Registró una forma de pago');
            return response('exito');
          }catch(\Exception $e){
            return response($e->getMessage());
          }
        }else{
          try{
            Formapago::create($request->All());
            bitacora('Registró una forma de pago');
            return redirect('/formapagos')->with('mensaje','Registro almacenado con éxito');
          }catch(\Exception $e){
            return redirect('/formapagos/create')->with('error','Ocurrió un error, contacte al administrador');
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
        $formapago = Formapago::findorFail($id);

        return view('formapagos.show', compact('formapago'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formapago = Formapago::find($id);
        return view('formapagos.edit',compact('formapago'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(FormapagoRequest $request, $id)
    {
        $formapago = Formapago::find($id);
        $formapago->fill($request->All());
        $formapago->save();
        bitacora('Modificó un registro');
        return redirect('/formapagos')->with('mensaje','Registro modificado con éxito');
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

    public function baja($cadena)
    {

        $datos = explode("+", $cadena);
        $id=$datos[0];
        $motivo=$datos[1];
        //dd($id);
        $formapago = Formapago::find($id);
        $formapago->estado=2;
        $formapago->motivo=$motivo;
        $formapago->fechabaja=date('Y-m-d');
        $formapago->save();
        bitacora('Dió de baja a un registro');
        return redirect('/formapagos')->with('mensaje','Registro dado de baja');
    }

    public function alta($id)
    {

        //$datos = explode("+", $cadena);
        ////$id=$datos[0];
        //$motivo=$datos[1];
        //dd($id);
        $formapago = Formapago::find($id);
        $formapago->estado=1;
        $formapago->motivo=null;
        $formapago->fechabaja=null;
        $formapago->save();
        Bitacora::bitacora('Dió de alta a un registro');
        return redirect('/formapagos')->with('mensaje','Registro dado de alta');
    }
}
