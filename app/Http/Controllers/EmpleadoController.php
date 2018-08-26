<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\Tipocontrato;
use App\CategoriaEmpleado;
use App\Bitacora;
use App\Http\Requests\EmpleadoRequest;

class EmpleadoController extends Controller
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
        if($estado == "" )$estado = 1;
        if($estado == 1)
        {
            $empleados = Empleado::where('estado',$estado)->get();
            return view('empleados.index',compact('empleados','estado'));
        }
        if($estado == 2)
        {
            $empleados = Empleado::where('estado',$estado)->get();
            return view('empleados.index',compact('empleados','estado'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipocontratos = Tipocontrato::where('estado',1);
        return view('empleados.create',compact('tipocontratos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpleadoRequest $request)
    {
      
      if($request->ajax())
      {
        try{
          Empleado::create([
            'nombre' => $request->nombre,
            'dui' => $request->dui,
            'nit' => $request->nit,
            'sexo' => $request->sexo,
            'telefono_fijo' => $request->telefono_fijo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => invertir_fecha($request->fecha_nacimiento),
            'num_contribuyente' => $request->num_contribuyente,
            'num_seguro_social' => $request->num_seguro_social,
            'num_afp' => $request->num_afp,
          ]);
          return response()->json([
            'mensaje' => 'exito'
          ]);
        }catch(\Exception $e)
        {
          return response()->json([
            'mensaje' => 'error'
          ]);
        }
      }else{
        try{
          Empleado::create([
            'nombre' => $request->nombre,
            'dui' => $request->dui,
            'nit' => $request->nit,
            'sexo' => $request->sexo,
            'telefono_fijo' => $request->telefono_fijo,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => invertir_fecha($request->fecha_nacimiento),
            'num_contribuyente' => $request->num_contribuyente,
            'num_seguro_social' => $request->num_seguro_social,
            'num_afp' => $request->num_afp,
          ]);
          return redirect('/empleados')->with('mensaje', 'Empleado registrado exitosamente');
        }catch(\Exception $e){
          return redirect('empleados/create')->with('error','Ocurrió un error, contacte al administrador');
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
        $empleado = Empleado::findorFail($id);
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado = Empleado::findorFail($id);
        return view('empleados.edit',compact('empleado'));
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
        $empleado = Empleado::find($id);
        $empleado->fill($request->All());
        $empleado->save();
        bitacora('Modificó un registro');
        return redirect('empleados')->with('mensaje','Registro modificado con éxito');
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
