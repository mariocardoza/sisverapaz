<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Bitacora;
use App\Http\Requests\ProveedorRequest;

class ProveedorController extends Controller
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
        $estado = $request->get('estado');
        if($estado == "" )$estado=1;
        if ($estado == 1) {
            $proveedores = Proveedor::where('estado',$estado)->get();
            return view('proveedores.index',compact('proveedores','estado'));
        }
        if ($estado == 2) {
            $proveedores = Proveedor::where('estado',$estado)->get();
            return view('proveedores.index',compact('proveedores','estado'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProveedorRequest $request)
    {
      if($request->ajax())
      {
        try{
          Proveedor::create($request->All());
          bitacora('Registro un Proveedor');
          return Response()->json([
            'mensaje' => 'exito'
          ]);
        }catch(\Exception $e)
        {
          return Response()->json([
            'mensaje' => 'error',
            'codigo' => $e->getMessage()
          ]);
        }
      }else{
        try{
          Proveedor::create($request->All());
          bitacora('Registro un Proveedor');
          return redirect('/proveedores')->with('mensaje','Registro almacenado con éxito');
        }catch(\Exception $e)
        {
          return redirect('proveedores/create')->with('error','Ocurrió un error, contacte al administrador');
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
        $proveedor = Proveedor::findorFail($id);

        return view('proveedores.show',compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);

        return view('proveedores.edit',compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProveedorRequest $request, $id)
    {
        $proveedor = Proveedor::find($id);
        $proveedor->fill($request->All());
        $proveedor->save();
        bitacora('Modificó un Proveedor');
        return redirect('/proveedores')->with('mensaje','Registro modificado con éxito');
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
        $proveedor = Proveedor::find($id);
        $proveedor->estado=2;
        $proveedor->motivo=$motivo;
        $proveedor->fechabaja=date('Y-m-d');
        $proveedor->save();
        bitacora('Dió de baja a un proveedores');
        return redirect('/proveedores')->with('mensaje','Proveedor dado de baja');
    }

    public function alta($id)
    {

        //$datos = explode("+", $cadena);
        ////$id=$datos[0];
        //$motivo=$datos[1];
        //dd($id);
        $proveedor = Proveedor::find($id);
        $proveedor->estado=1;
        $proveedor->motivo=null;
        $proveedor->fechabaja=null;
        $proveedor->save();
        Bitacora::bitacora('Dió de alta a un proveedor');
        return redirect('/proveedores')->with('mensaje','Proveedor dado de alta');
    }


}
