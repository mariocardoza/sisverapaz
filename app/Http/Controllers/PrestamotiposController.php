<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prestamotipo;
use Validator;
class PrestamotiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos=Prestamotipo::where('estado',1)->get();
        return view('Prestamotipos.index',compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prestamotipos.create');
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
        Prestamotipo::create([
            'id'=>date('Yidisus'),
            'nombre'=>$request->nombre
        ]);

        return array(1,"exito");
    }

    protected function validar(array $data)
    {
       
        return Validator::make($data, [
            'nombre' => 'required|unique:prestamotipos',
        ]);

        
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
        $tipo = Prestamotipo::find($id);
        return array(1,"éxito",$tipo);
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
        $tipo = Prestamotipo::find($id);
        $tipo->nombre = $request->nombre;
        $tipo->save();
        return array(1,"exitoso",$tipo);
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
        $id = $datos[0];
        //$motivo = 

        $tipo = Prestamotipo::find($id);
        $tipo->estado = 2;
        $tipo->save();

        return redirect("prestamotipos")->with("mensaje","Tipo eliminado");
    }
}
