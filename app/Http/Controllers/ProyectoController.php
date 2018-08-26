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
use App\Cuentaproy;
use App\Http\Requests\ProyectoRequest;
use App\Http\Requests\FondocatRequest;
use DB;
use Session;

class ProyectoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','api']);
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

    public function guardarCategoria(FondocatRequest $request)
    {
      if($request->ajax())
      {
        try{
          $fondo = Fondocat::create($request->All());
          return response()->json([
            'mensaje' => 'exito',
            'datos' => $fondo
          ]);
        }catch(\Exception $e){
          return response()->json([
            'mensaje' => 'error'
          ]);
        }
      }
    }

    public function listarFondos(Request $request)
    {
      if($request->id){
        $id=$request->id;
          $fondos = DB::table('fondocats')
                    ->whereNotExists(function ($query) use ($id)  {
                         $query->from('fondos')
                            ->whereRaw('fondos.fondocat_id = fondocats.id')
                            ->whereRaw('fondos.proyecto_id ='.$id);
                        })->get();
          return response($fondos);
      }else{
        return Fondocat::get();
      }

    }


    public function deleteMonto($id)
    {
      if(isset($id))
      {
        $fondos = Session::get('fondos');
        $fondosbase = Session::get('fondosbase');
        try{
          for($i=0; $i< count($fondos);$i++) {
              if($fondos[$i]['cat_id'] == $id && $fondos[$i]['existe'] == true){

                $fondos[$i]['existe']=false;
              }
              Session::put('fondos', $fondos);
          }

          for($i=0; $i< count($fondosbase);$i++) {
              if($fondosbase[$i]['cat_id'] == $id && $fondosbase[$i]['existe'] == true){
                //Session::forget('fondosbase.'.$i);
                $fondosbase[$i]['existe']=false;
                $fondo=Fondo::where('fondocat_id',$id)->first();
                $fondo->delete();
              }
              Session::put('fondosbase',$fondosbase);
          }

          return response()->json([
              'mensaje' => 'borrado',
            ]);
        }catch(\Exception $e){
          return response()->json([
              'mensaje' => $e->getMessage(),
            ]);
        }
      }

    }

    public function sesion (Request $request)
    {
      $fondo = [
        'existe' => true,
        'cat_id' => intval($request->cat_id),
        'categoria' => $request->categoria,
        'monto' => floatval($request->monto),
      ];

      Session::push('fondos', $fondo);

      return Response()->json([
        'fondos' => Session::get('fondos')
      ]);
    }

    public function getsesion ()
    {
      $s1=Session::get('fondos');
      $s2=Session::get('fondosbase');
      if(count($s1) >0 && count($s2)>0){
        $resultado = array_merge($s1, $s2);
      }else{
        if(count($s1) == 0 ){
          $resultado=$s2;
        }else{
          if(count($s2)==0){
            $resultado=$s1;
          }else{
            $resultado=null;
          }
        }
      }

      return response($resultado);
    }

    public function limpiarsesion()
    {
      Session::forget('fondos');
      Session::forget('fondosbase');
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

        Session::forget('fondosbase');

      if(count($proyecto->fondo) >0){
      //  for($i=0;$i<count($proyecto->fondo);$i++){
        foreach($proyecto->fondo as $fondo){
          $fondo = [
            'existe' => true,
            'cat_id' => intval($fondo->fondocat->id),
            'categoria' => str_replace ( " " , "_" , $fondo->fondocat->categoria ),
            'monto' => floatval($fondo->monto),
          ];
          //guarda en una sesion llamada fondosbase
          Session::push('fondosbase', $fondo);
        }
      }

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
      $fondos= Session::get('fondos');
      $fondosbase= Session::get('fondosbase');
      //dd($fondosbase);
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

        //Insertar datos que estan en la sesion para la guardarlos en la base
        for($i=0; $i< count($fondos);$i++) {
          if($fondos[$i]['existe']==true){
            $fondonuevo=new Fondo();
            $fondonuevo->proyecto_id = $proyecto->id;
            $fondonuevo->fondocat_id = $fondos[$i]['cat_id'];
            $fondonuevo->monto = $fondos[$i]['monto'];
            $fondonuevo->save();
          }
        }

        for($i=0; $i<count($fondosbase); $i++){
          if($fondosbase[$i]['existe']==true){
            $fondo=Fondo::where('fondocat_id',$fondosbase[$i]['cat_id'])->first();
            $fondo->monto=$fondosbase[$i]['monto'];
            $fondo->save();
          }
        }
        //elimina la sesion ya que ya se guardaron
        Session::forget('fondos');
        Session::forget('fondosbase');

        bitacora('Modificó  Proyecto');
        return redirect('/proyectos')->with('mensaje','Infomacion del proyecto modificada con éxito');
      }catch(\Exception $e){
        return redirect('proyectos/'.$id.'/edit')->with('error','Ocurrió un error. contacte al administrador '.$e->getMessage());
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
