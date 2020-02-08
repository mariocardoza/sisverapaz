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
        $giros=Giro::where('estado',1)->get();
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
}
