<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banco;
use App\Http\Requests\BancoRequest;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $estado=(!isset($request->estado))?1:$request->estado;
        $bancos=Banco::where('estado',$estado)->orderby('nombre')->get();
        return view('bancos.index',compact('bancos','estado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bancos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BancoRequest $request)
    {
        $banco= new Banco();
        $banco->nombre=$request->nombre;
        $banco->save();

        return redirect('bancos')->with('mensaje','Banco registrado');
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
        $banco=Banco::find($id);
        return view('bancos.edit',compact('banco'));
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
        $banco=Banco::find($id);
        if($banco->nombre!=$request->nombre){
            $this->validate($request,['nombre'=>'required|unique:bancos|min:5']);
        }
        $banco->nombre=$request->nombre;
        $banco->save();

        return redirect('bancos')->with('mensaje','Registro modificado con éxito');
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
        $banco = Banco::find($id);
        $banco->estado=0;
        $banco->motivo=$motivo;
        $banco->fechabaja=date('Y-m-d');
        $banco->save();
        bitacora('Dió de baja a un banco');
        return redirect('/bancos')->with('mensaje','Banco dado de baja');

    }
    public function alta($id)
    {
        $banco = Banco::find($id);
        $banco->estado=1;
        $banco->motivo=null;
        $banco->fechabaja=null;
        $banco->save();
        bitacora('Dió de alta a un registro');
        return redirect('/bancos')->with('mensaje','Registro dado de alta');
    }
}