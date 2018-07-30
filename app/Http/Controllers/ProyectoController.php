<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\Organizacion;
use App\Bitacora;
use App\Presupuesto;
use App\Presupuestodetalle;
use App\Fondocat;
use App\Fondo;
use App\Fondoorg;
use App\Cuentaproy;
use App\Http\Requests\ProyectoRequest;
use App\Http\Requests\FondocatRequest;
use DB;
use Session;

class ProyectoController extends Controller
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
        //if($estado == "" )$estado=1;
        if($estado == ""){
          $proyectos = Proyecto::orderBy('id','asc')->get();
          return view('proyectos.index',compact('proyectos','estado'));
        }
        if ($estado == 1) {
            $proyectos = Proyecto::where('estado',$estado)->orderBy('id','asc')->get();
            return view('proyectos.index',compact('proyectos','estado'));
        }
        if ($estado == 2) {
            $proyectos = Proyecto::where('estado',$estado)->orderBy('id','asc')->get();
            return view('proyectos.index',compact('proyectos','estado'));
        }
    }

    public function guardarOrganizacion(Request $request)
    {
      if($request->ajax())
      {
        try{
          Organizacion::create($request->All());
          return response()->json([
            'mensaje' => 'Organización creada exitosamente'
          ]);
        }catch(\Exception $e){
          return response()->json([
            'mensaje' => 'error'
          ]);
        }

      }
    }

    public function guardarCategoria(FondocatRequest $request)
    {
      if($request->ajax())
      {
        try{
          Fondocat::create($request->All());
          return response()->json([
            'mensaje' => 'Organización creada exitosamente'
          ]);
        }catch(\Exception $e){
          return response()->json([
            'mensaje' => 'error'
          ]);
        }

      }
    }

    public function listarOrganizaciones()
    {
        return Organizacion::get();
    }

    public function listarFondos()
    {
        return Fondocat::get();
    }

    public function listarFondose($id)
    {
        $fondos = DB::table('fondocats')
                  ->whereNotExists(function ($query) use ($id)  {
                       $query->from('fondos')
                          ->whereRaw('fondos.fondocat_id = fondocats.id')
                          ->whereRaw('fondos.proyecto_id ='.$id);
                      })->get();
        return $fondos;
    }

    public function getMontos($id)
    {
      /*return $categorias = DB::table('fondocats')
                ->whereExists(function ($query) use ($id) {
                     $query->from('fondos')
                        ->whereRaw('fondos.fondocat_id = fondocats.id')
                        ->whereRaw('fondos.proyecto_id ='.$id);
                    })->get();*/
      return Fondo::where('proyecto_id',$id)->with('fondocat','proyecto')->get();
    }

    public function deleteMonto($id)
    {
      if(isset($id))
      {
        //$fondo = Fondo::findorFail($id);
        //$fondo->delete();
        $fondos = Session::get('fondos');

        foreach ($fondos as $key => $val) {
            //echo $val[$key]['cat_id'];

        }


        return response()->json([
            'mensaje' => $fondos[0]->cat_id
          ]);
      }

    }

    public function addMonto(Request $request)
    {
      if($request->Ajax())
      {
        Fondo::create([
          'proyecto_id' => $request->id,
          'fondocat_id' => $request->cat,
          'monto' => $request->monto,
        ]);
        return response()->json([
            'mensaje' => $request->All()
          ]);
      }
    }
    public function sesion (Request $request)
    {
      $fondo = [
        'cat_id' => $request->cat_id,
        'categoria' => $request->categoria,
        'monto' => $request->monto,

      ];

      Session::push('fondos', $fondo);

      return Response()->json([
        'fondos' => Session::get('fondos')
      ]);
    }

    public function getsesion ()
    {
      return response(Session::get('fondos'));
    }

    public function limpiarsesion()
    {
      Session::forget('fondos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizaciones = Organizacion::all();
        return view('proyectos.create',compact('organizaciones'));

        //return view('proyectos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProyectoRequest $request)
    {
      if($request->ajax())
      {
        DB::beginTransaction();
        try{
          $montosorg = $request->montosorg;
          $montos = $request->montos;

          $proyecto = Proyecto::create([
              'nombre' => $request->nombre,
              'monto' => $request->monto,
              'direccion' => $request->direccion,
              'fecha_inicio' => invertir_fecha($request->fecha_inicio),
              'fecha_fin' => invertir_fecha($request->fecha_fin),
              'motivo' => $request->motivo,
              'beneficiarios' => $request->beneficiarios,
          ]);

          if(isset($montos))
          {
            foreach ($montos as $monto) {
              Fondo::create([
                'proyecto_id' => $proyecto->id,
                'fondocat_id' => $monto['categoria'],
                'monto' => $monto['monto'],
              ]);
            }
          }

          Cuentaproy::create([
            'proyecto_id' => $proyecto->id,
            'monto_inicial' => $request->monto,
          ]);
          bitacora('Registró un proyecto');
          DB::commit();
          return response()->json([
            'mensaje' => 'exito'
          ]);
      }catch (\Exception $e){
        DB::rollback();
        return response()->json([
          'mensaje' => $e->getMessage()
        ]);
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
        $proyecto = Proyecto::findorFail($id);
        //$presupuesto = Presupuesto::where('proyecto_id',$proyecto->id)->get()->first();
        return view('proyectos.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proyecto = Proyecto::find($id);
        $organizaciones = Organizacion::all();
        return view('proyectos.edit',compact('proyecto','organizaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(ProyectoRequest $request, $id)
    {
      try{
        $proyecto = Proyecto::findorFail($id);
        $proyecto->nombre=$request->nombre;
        $proyecto->monto=$request->monto;
        $proyecto->motivo=$request->motivo;
        $proyecto->fecha_inicio=invertir_fecha($request->fecha_inicio);
        $proyecto->fecha_fin=invertir_fecha($request->fecha_fin);
        $proyecto->direccion=$request->direccion;
        $proyecto->beneficiarios=$request->beneficiarios;
        $proyecto->save();
        bitacora('Modificó un Proyecto');
        return redirect('/proyectos')->with('mensaje','Registro modificado con éxito');
      }catch(\Exception $e){
        return redirect('proyectos/'.$id.'/edit')->with('error','Ocurrió un error. contacte al administrador');
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
      try{
        $datos = explode("+", $cadena);
        $id=$datos[0];
        $motivo=$datos[1];
        $proyecto = Proyecto::find($id);
        $proyecto->estadoanterior=$proyecto->estado;
        $proyecto->estado=10;
        $proyecto->motivobaja=$motivo;
        $proyecto->fechabaja=date('Y-m-d');
        $proyecto->save();
        bitacora('Dió de baja a un proyecto');
        return redirect('/proyectos')->with('mensaje','Proyecto dado de baja');
      }catch(\Exception $e){
        return redirect('/proyectos')->with('error','Ocurrió un error, contacte al administrador');
      }

    }

    public function alta($id)
    {
      try{
        $proyecto = Proyecto::find($id);
        $proyecto->estado=$proyecto->estadoanterior;
        $proyecto->motivobaja=null;
        $proyecto->fechabaja=null;
        $proyecto->estadoanterior=null;
        $proyecto->save();
        Bitacora::bitacora('Dió de alta a un proyecto');
        return redirect('/proyectos')->with('mensaje','Proyecto dado de alta');
      }catch(\Exception $e){
        return redirect('/proyectos')->with('error','Ocurrió un error, contacte al administrador');
      }

    }
}
