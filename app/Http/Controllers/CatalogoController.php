<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Catalogo;
use App\Bitacora;
//use App\Http\Requests\CatalogoRequest;

class CatalogoController extends Controller
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
        if($estado == "")$estado = 1;
        if($estado == 1)
        {
            $catalogos = Catalogo::where('estado', $estado)->get();
            return view('catalogos.index',compact('catalogos','estado'));
        }
        if($estado == 2)
        {
            $catalogos = Catalogo::where('estado',$estado)->get();
            return view('catalogos.index',compact('catalogos','estado'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();
        $catalogos = Catalogo::all();
        return view('catalogos.create',compact('categorias','catalogos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->Ajax())
        {
          try{
              Catalogo::create($request->All());
              return response()->json([
                  'mensaje' => 'exito'
              ]);
          }catch(\Exception $e){
              return response()->json([
                  'mensaje' => $e->getMessage()
              ]);
          }
        }else{
          Catalogo::create($request->All());
          return redirect('catalogos')->with('mensaje','Catálogo registrado');
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
        $catalogo = Catalogo::findorFail($id);
        return view('catalogos.show',compact('catalogo'));
    }
     /* Show the form for editing the specified resource.
     */

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $catalogo = Catalogo::findorFail($id);
        $categorias = Categoria::where('estado',1)->get();
        return view('catalogos.edit', compact('catalogo', 'categorias'));
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
        $catalogo = Catalogo::find($id);
        $catalogo->fill($request->All());
        $catalogo->save();
        return redirect('/catalogos')->with('mensaje','Información actualizada');
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
        try{
        $datos = explode("+",$cadena);
        $id = $datos[0];
        $motivo = $datos[1];

        $catalogo = Catalogo::find($id);
        $catalogo->estado = 2;
        $catalogo->motivo = $motivo;
        $catalogo->fechabaja = date('Y-m-d');
        $catalogo->save();
        bitacora('Dió de baja catálogo');
        return redirect('/catalogos')->with('mensaje','Catálogo dado de baja');
    }catch(\Exception $e){
        return redirect('/catalogos')->with('mensaje','Error, no se puede dar de baja');
    }
    }

    public function alta($id)
    {
        $catalogo = Catalogo::find($id);
        $catalogo->estado = 1;
        $catalogo->motivo = null;
        $catalogo->fechabaja = null;
        $catalogo->save();
        Bitacora::bitacora('Dió de alta un catálogo');
        return redirect('/catalogos')->with('mensaje','Catálogo dado de alta');
    }
}
