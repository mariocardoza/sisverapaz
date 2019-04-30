<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inmueble;
use App\Contribuyente;
use App\Http\Requests\InmuebleRequest;
class InmuebleController extends Controller
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

    public function index()
    {
        $inmuebles = Inmueble::all();
        return view('inmuebles.index',compact('inmuebles'));
    }

    public function guardarContribuyente(Request $request)
    {
        if($request->ajax())
        {
            Contribuyente::create($request->All());
            return response()->json([
                'mensaje' => 'Registro creado exitosamente']);
        }
    }

    public function listarContribuyentes()
    {
        return Contribuyente::where('estado',1)->get();   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contribuyentes = Contribuyente::where('estado', 1)->orderBy('nombre')->pluck('nombre', 'id');
        //dd($contribuyentes);
        return view('inmuebles.create', compact('contribuyentes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InmuebleRequest $request)
    {
        if($request->ajax()){
            try{
                $inmuebles = Inmueble::create([
                    'numero_catastral' => $request->numero_catastral,
                    'tipo_inmueble' => $request->tipo_inmueble,
                    'contribuyente_id' => $request->contribuyente_id,
                    'direccion_inmueble' => $request->direccion_inmueble,
                    'medida_inmueble' => $request->medida_inmueble,
                    'numero_escritura' => $request->numero_escritura,
                    'metros_acera' => $request->metros_acera
                ]);
                return response()->json([
                    'mensaje' => 'exito',
                  ]);
            }catch(Exception $e){
                return response()->json([
                    'mensaje' => 'error',
                  ]);
            }
        }else{
          $inmuebles = Inmueble::create([
            'numero_catastral' => $request->numero_catastral,
            'tipo_inmueble' => $request->tipo_inmueble,
            'contribuyente_id' => $request->contribuyente_id,
            'direccion_inmueble' => $request->direccion_inmueble,
            'medida_inmueble' => $request->medida_inmueble,
            'numero_escritura' => $request->numero_escritura,
            'metros_acera' => $request->metros_acera
        ]);
        return redirect('inmuebles')->with('mensaje','Inmueble registrado con exito');  
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
        //
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
        //
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
