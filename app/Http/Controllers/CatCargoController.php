<?php

namespace App\Http\Controllers;

use App\CatCargo;
use Illuminate\Http\Request;
use Validator;

class CatCargoController extends Controller
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
        if($request->estado=='')
        $estado=1;
        else
        $estado=$request->estado;
        $catcargos = CatCargo::where('estado',$estado)->get();
        return view('cargos.catcargos.index',compact('catcargos'));
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
            $catcategorias = CatCargo::create($request->all());
            return array(1,'éxito',$catcategorias);
        }catch(exception $e){
            return array(-1, $e);
        }
    }

    protected function validar(array $array)
    {
        return Validator::make($array, ['nombre'=>'required|unique:cat_cargos']);
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
        $catcargo = CatCargo::find($id);
        return array(1,"exitoso",$catcargo);
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
        $catcargo = CatCargo::find($id);
        $catcargo->nombre = $request->nombre;

        $catcargo->save();
        return array(1,"exitoso",$catcargo);
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

        $catcargo = CatCargo::find($id);
        if($catcargo->cargo->count() == 0):
            $catcargo->estado = 2;
            $catcargo->save();
            bitacora('Dió de baja una categoría');
            return redirect('/catcargos')->with('mensaje','Categoría dada de baja');
        else:
            return redirect('/catcargos')->with('info','La categoría posee subcategorías no debe eliminarse');
        endif;
    }

    public function alta($id)
    {
        $catcargo = CatCargo::find($id);
        $catcargo->estado=1;
        $catcargo->save();
        Bitacora:bitacora("Dió de alta una categoría");

        return redirect('/catcargos')->with('mensaje', 'Categoría dada de alta');
    }
}
