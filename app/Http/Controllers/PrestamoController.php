<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prestamo;
use App\Empleado;
use App\Prestamotipo;
use DB;
use App\http\Requests\PrestamoRequest;

class PrestamoController extends Controller
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
      $estado = $request->get('estado');
      if($estado == "" )$estado=1;
      if ($estado == 1) {
          $prestamos = Prestamo::where('estado',$estado)->get();
          return view('prestamos.index',compact('prestamos','estado'));
      }
      if ($estado == 2) {
          $prestamos = Prestamo::where('estado',$estado)->get();
          return view('prestamos.index',compact('prestamos','estado'));
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $lostipos=Prestamotipo::where('estado',1)->get();
      foreach ($lostipos as $tipo) {
        $tipos[$tipo->id]=$tipo->nombre;
      }
      
      //$empleados = Empleado::where('estado',1)->get();
    //   $empleados=DB::select('SELECT id FROM empleados WHERE estado =1 EXCEPT SELECT empleado_id FROM prestamos');
      // $listaempleados=DB::select('SELECT id FROM empleados WHERE NOT id IN(SELECT empleado_id FROM prestamos where estado=1) AND estado=1 ORDER BY nombre ASC');
    //   Select * From Tabla1 where Not Codigo In (Select Codigo From Tabla2)
      //dd($empleados);}
      $listaempleados=Empleado::where('estado',1)->orderBy('nombre','ASC')->get();
      $empleados= [];
      foreach($listaempleados as $e){
        if($e->detalleplanilla->count()>0){
          $empleados[$e->id]=$e->nombre;
        }
      }
      return view('prestamos.create',compact('empleados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrestamoRequest $request)
    {
      if($request->Ajax()){
        Prestamo::create($request->All());
        return array(1,"exito");
      }else{
        Prestamo::create($request->All());
        return redirect('/prestamos')->with('mensaje', 'Préstamo registrado exitosamente');
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
        $prestamo=Prestamo::find($id);
        return view('prestamos.show',compact('prestamo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $lostipos=Prestamotipo::where('estado',1)->get();
      foreach ($lostipos as $tipo) {
        $tipos[$tipo->id]=$tipo->nombre;
      }
      
        $prestamo=Prestamo::find($id);
        return view('prestamos.edit',compact('prestamo'));
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
      //dd($request->All());
        $prestamo=Prestamo::find($id);
        $prestamo->fill($request->all());
        $prestamo->save();
        return redirect('/prestamos')->with('mensaje', 'Registro modificado con éxito');
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
