<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Giro;
use Validator;

class GiroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $estado=(!isset($request->estado))?1:$request->estado;
        $giros=Giro::where('estado',$estado)->get();
        return view('giros.index', compact('giros','estado'));
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
        Giro::create([
            'nombre'=>$request->nombre
        ]);

        return array(1,"éxito");
    }

    protected function validar(array $data)
    {
        return Validator::make($data, [
            'nombre' => 'required|unique:bancos',
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
        $giro=Giro::find($id);
        
        return array(1,"exitoso",$giro);
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
        $giro=Giro::find($id);
        if($giro->nombre!=$request->nombre){
            $this->validate($request,['nombre'=>'required|unique:giros|min:2']);
        }
        $giro->nombre=$request->nombre;
        $giro->save();

        return array(1,"éxito");
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
        $motivo = $datos[1];
        $especialista = Giro::find($id);
        $especialista->estado = 2;
        //$especialista->motivo = $motivo;
        //$especialista->fecha_baja = date('Y-m-d');
        $especialista->save();
        bitacora('Dió de baja un giro de proveedores');
        return redirect('giros')->with('mensaje','Registro dado de baja');
    }

    public function alta($id)
    {
        $especialista = Giro::find($id);
        $especialista->estado = 1;
        //$especialista->motivo = null;
        //$especialista->fecha_baja = null;
        $especialista->save();
        bitacora('Dió de alta un giro de proveedores');
        return redirect('giros')->with('mensaje','Registro dado de alta');
    }
}
