<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContribuyenteRequest;
use App\Contribuyente;
use Carbon\Carbon;
use App\Bitacora;

class ContribuyenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $contribuyentes=Contribuyente::all();
        return view('contribuyentes.index',compact('contribuyentes'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contribuyentes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContribuyenteRequest $request)
    {
        if($request->ajax()){
            try{
               $contribuyente= Contribuyente::create([
                    'nombre'=>$request->nombre,
                    'dui'=>$request->dui,
                    'nit'=>$request->nit,
                    'sexo'=>$request->sexo,
                    'telefono'=>$request->telefono,
                    'nacimiento'=>\invertir_fecha($request->nacimiento),
                    'direccion'=>$request->direccion,
                ]);
                bitacora('Registro un contribuyente');
              return array(1,"exito",$contribuyente);
            }catch(\Exception $e){
              return response(-1,"error",$e->getMessage());
            }
        }else{
           Contribuyente::create($request->All());
            bitacora('Registro un contribuyente');
            return redirect('/contribuyentes')->with('mensaje','Registro almacenado con éxito'); 
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
        $c = Contribuyente::findorFail($id);

        return view('contribuyentes.show',compact('c'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contribuyente = Contribuyente::findorFail($id);

        return view('contribuyentes.edit',compact('contribuyente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContribuyenteRequest $request, $id)
    {
        $contribuyente = Contribuyente::find($id);
        $contribuyente->fill($request->All());
        $contribuyente->save();
        bitacora('Modificó un Proveedor');
        return redirect('/contribuyentes')->with('mensaje','Registro modificado con éxito');
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
        $contribuyente = Contribuyente::find($id);
        $contribuyente->estado=2;
        $contribuyente->motivo=$motivo;
        $contribuyente->fechabaja=date('Y-m-d');
        $contribuyente->save();
        bitacora('Dió de baja a un contribuyente');
        return redirect('/contribuyentes')->with('mensaje','Contribuyente dado de baja');
    }

    public function alta($id)
    {
      
       //$datos = explode("+", $cadena);
       ////$id=$datos[0];
       //$motivo=$datos[1];
        //dd($id);
        $contribuyente = Contribuyente::find($id);
        $contribuyente->estado=1;
        $contribuyente->motivo="";
        $contribuyente->fechabaja=null;
        $contribuyente->save();
        Bitacora::bitacora('Dió de alta a un contribuyente');
        return redirect('/contribuyentes')->with('mensaje','Contribuyente dado de alta');
    }
}
