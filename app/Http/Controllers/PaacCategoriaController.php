<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaacCategoria;
use Validator;

class PaacCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias=PaacCategoria::where('estado',1)->get();
        return view('paacs.categorias.index',compact('categorias'));
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'nombre.required'=>'El nombre es obligatorio',
            'nombre.unique'=>'El nombre de cargo ya esta en uso',
        );
        return Validator::make($data, [
            'nombre' => 'required|unique:paac_categorias',
        ],$mensajes);
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
            $cargo=PaacCategoria::create($request->All());
            return array(1,"exito",$cargo);
        }catch(Exception $e){
            return array(-1,"exito",$e->getMessage());
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
        $categoria=PaacCategoria::find($id);
        return array(1,"exito",$categoria);
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
        try{
            $cargo=PaacCategoria::find($id);
            $cargo->fill($request->all());
            $cargo->save();
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
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
        $datos = explode("+",$cadena);
        $id = $datos[0];
        $motivo = $datos[1];

        $categoria = PaacCategoria::find($id);
        $categoria->estado = 2;
        $categoria->save();
        bitacora('Dió de baja categoría de plan anual');
        return redirect('/paaccategorias')->with('mensaje','Categoría dada de baja');
    }

    public function alta($id)
    {
        $categoria = PaacCategoria::find($id);
        $categoria->estado = 1;
    
        $categoria->save();
        bitacora('Dió de baja categoría de plan anual');
        return redirect('/paaccategorias')->with('mensaje','Categoría dada de alta');
    }
}
