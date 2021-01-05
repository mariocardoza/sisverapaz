<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\ContratoProyecto;
use App\Organizacion;
use App\Bitacora;
use App\Presupuesto;
use App\Presupuestodetalle;
use App\Cuenta;
use App\Fondo;
use App\Cuentaproy;
use App\Categoria;
use App\ProyectoActa;
use App\Formapago;
use App\Calendarizacion;
use App\Solicitudcotizacion;
use Redirect;
use App\ProyectoPlanilla;
use App\Licitacion;
use App\Http\Requests\ProyectoRequest;
use App\Http\Requests\FondocatRequest;
use DB;
use Validator;
use Session;
use Storage;

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
        $anios=DB::table('proyectos')->distinct()->get(['anio']);
        
        //if($estado == "" )$estado=1;
       
          $proyectos = Proyecto::whereYear('created_at',date("Y"))->orderBy('created_at','DESC')->get();
          return view('proyectos.index',compact('proyectos','estado','anios'));
        
        
    }

    public function mapas()
    {
      $proyectos=DB::table('proyectos as p')
        ->select('p.id','p.nombre','p.beneficiarios','p.codigo_proyecto','p.direccion',
        'p.estado','p.fecha_inicio','p.fecha_fin','p.lat','p.lng','p.motivo','p.monto',
        DB::RAW('(select
            sum(ip.porcentaje)
        FROM
            indicadores_proyectos AS ip
        WHERE
            ip.proyectos_id = p.id
        AND ip.estado = 2) as avance'))
        ->where('p.anio','=',date('Y'))
        ->get();
      return view('proyectos.mapa',compact('proyectos'));
    }

    public function cambiarlicitacion(Request $request)
    {
      try{
        $proyecto=Proyecto::find($request->id);
        $proyecto->estado=$request->estado;
        $proyecto->save();
        $texto=proyecto_estado($request->estado,$request->id);
        return array(1,"exito",$proyecto,$texto);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public function cambiarubicacion(Request $request)
    {
      try{
        $proyecto=Proyecto::findorFail($request->proyecto_id);
        $proyecto->lat=$request->lat;
        $proyecto->lng=$request->lng;
        $proyecto->save();
        return array(1,"exito");
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
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
          $fondos = DB::table('cuentas')
                    ->whereNotExists(function ($query) use ($id)  {
                         $query->from('fondos')
                            ->whereRaw('fondos.cuenta_id = cuentas.id')
                            ->whereRaw('fondos.proyecto_id ='.$id);
                        })->get();
          return response($fondos);
      }else{
        return Cuenta::get();
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

    public function informacion($id)
    {
      $retorno=Proyecto::informacion($id);
      return $retorno;
    }

    public function solicitudes($id)
    {
      $retorno=Proyecto::solicitudes($id);
      return $retorno;
    }

    public function contratos($id)
    {
      $retorno=ContratoProyecto::mostrar_contratos($id);
      return $retorno;
    }

    public function subircontrato(Request $request)
    {
      $this->validar_contrato($request->all())->validate();
      $archivo="Contrato_".$request->nombre."_".date("Ymdhis").".".$request->file('archivo')->getClientOriginalExtension();
      try{
        $request->file('archivo')->storeAs('proyectos/contratos', $archivo);
        $contrato=ContratoProyecto::create([
          'id'=>date('Yidisus'),
          'nombre'=>$request->nombre,
          'descripcion'=>$request->descripcion,
          'archivo'=>$archivo,
          'proyecto_id'=>$request->proyecto_id
        ]);

        $proy=Proyecto::find($request->proyecto_id);
        if($proy->tipo_proyecto==2):
          $proy->estado=6;
          $proy->save();
        endif;

        return array(1,"exito",$request->proyecto_id);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage);
      }
    }

    public function subiroferta(Request $request)
    {
      $this->validar_oferta($request->all())->validate();
      DB::beginTransaction();
      $proveedor=\App\Proveedor::find($request->proveedor_id);
      $proyecto=\App\Proyecto::find($request->proyecto_id);
      $archivo="Oferta_".$proveedor->nombre."_".date("d-m-Y_h_i_s_a").".".$request->file('archivo')->getClientOriginalExtension();
      try{
        $request->file('archivo')->storeAs('proyectos/ofertas', $archivo);
        $contrato=Licitacion::create([
          'proveedor_id'=>$request->proveedor_id,
          'archivo'=>$archivo,
          'proyecto_id'=>$request->proyecto_id
        ]);

        $proyecto->estado=4;
        $proyecto->save();
          DB::commit();
        return array(1,"exito",$request->proyecto_id);
      }catch(Exception $e){
        DB::rollback();
        return array(-1,"error",$e->getMessage);
      }
    }

    public function seleccionar_oferta(Request $r)
    {
        try{
          DB::beginTransaction();
          Licitacion::where('proyecto_id',$r->proyecto_id)->update(['estado'=>2]);
          $licitacion=Licitacion::find($r->licitacion_id);
          $licitacion->estado=1;
          $licitacion->save();

          $proy=Proyecto::find($r->proyecto_id);
          $proy->estado=5;
          $proy->save();
          DB::commit();
          return array(1,"exito");
        }catch(Exception $e){
          return array(-1,"error",$e->getMessage());
        }
    }

    public function subirbase(Request $request)
    {
      $this->validar_base($request->all())->validate();
      $proyecto=\App\Proyecto::find($request->proyecto_id);
      $proyecto->estado=3;
      $proyecto->save();
      $archivo="Base de licitacion proyecto_".$proyecto->nombre."_".date("d-m-Y_h_i_s_a").".".$request->file('archivo')->getClientOriginalExtension();
      try{
        $request->file('archivo')->storeAs('proyectos/bases_licitacion', $archivo);
        $contrato=\App\LicitacionBase::create([
          'archivo'=>$archivo,
          'proyecto_id'=>$request->proyecto_id
        ]);

        return array(1,"exito",$request->proyecto_id);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage);
      }
    }

    public function borrarlicitacion($id)
    {
      try{
        $licitacion=Licitacion::find($id);
        Storage::disk('local')->delete('proyectos/ofertas/'.$licitacion->archivo);
        $licitacion->delete();
      return array(1,"exito",$licitacion);
      }catch(Exception $e){

      }
    }

    public function subiracta(Request $request)
    {
      $this->validar_acta($request->all())->validate();
      try{
        DB::beginTransaction();
        $request->file('archivo')->storeAs('proyectos/actas', $request->file('archivo')->getClientOriginalName());
        $contrato=ProyectoActa::create([
          'id'=>date('Yidisus'),
          'descripcion'=>$request->descripcion,
          'archivo'=>$request->file('archivo')->getClientOriginalName(),
          'proyecto_id'=>$request->proyecto_id
        ]);

        $proyecto=Proyecto::find($request->proyecto_id);
        if($proyecto->tipo_proyecto==1){
          $proyecto->estado=12;
        }else{
          $proyecto->estado=11;
        }
        $proyecto->fecha_acta=date("Y-m-d");
        $proyecto->save();
          DB::commit();
        return array(1,"exito",$request->proyecto_id);
      }catch(Exception $e){
        DB::rollback();
        return array(-1,"error",$e->getMessage);
      }
    }

    public function bajar_acta($file_name)
    {
      $file = '/proyectos/actas/' . $file_name;
      //dd($file);
      $disk = Storage::disk('local');
      if ($disk->exists($file)) {
          $fs = Storage::disk('local')->getDriver();
          $stream = $fs->readStream($file);
          return \Response::stream(function () use ($stream) {
              fpassthru($stream);
          }, 200, [
              "Content-Type" => $fs->getMimetype($file),
              "Content-Length" => $fs->getSize($file),
              "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
          ]);
      } else {
        return Redirect::back()->with('error', 'Archivo no encontrado');
          //abort(404, "The backup file doesn't exist.");
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proyectos.create');

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
              'monto_desarrollo' => $request->monto_desarrollo,
              'codigo_proyecto'=>Proyecto::codigo_proyecto($request->monto),
              'tipo_proyecto'=>Proyecto::tipo_proyecto($request->monto),
              'lng'=>$request->lng,
              'lat'=>$request->lat,
              'anio'=>date("Y")
          ]);

          if(isset($montos))
          {
            foreach ($montos as $monto) {
              Fondo::create([
                'id'=>Fondo::retonrar_id_insertar(),
                'proyecto_id' => $proyecto->id,
                'cuenta_id' => $monto['categoria'],
                'monto' => $monto['monto'],
                'monto_disponible' => $monto['monto'],
              ]);
            }
          }

          Cuentaproy::create([
            'proyecto_id' => $proyecto->id,
            'monto' => $request->monto,
            'monto_inicial'=>0
          ]);
          bitacora('Registró un proyecto');
          DB::commit();
          return array(1,"exito");
      }catch (\Exception $e){
        DB::rollback();
        return array(-1, $e->getMessage(),$e->getLine(),$e);
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
        $categorias=Categoria::where('estado',1)->get();
        $formapagos=Formapago::where('estado',1)->get();
        //$presupuesto = Presupuesto::where('proyecto_id',$proyecto->id)->get()->first();
        return view('proyectos.show', compact('proyecto','categorias','formapagos'));
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


   

        return view('proyectos.edit',compact('proyecto'));
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

    public function versolicitud($id)
    {
      $retorno=Solicitudcotizacion::lasolicitud_proyecto($id);
      return $retorno;
    }

    public function presupuesto_categoria($id,$idproy)
    {
      $proyecto=Proyecto::find($idproy);
      if($id!=0){
        $detalles=DB::table('presupuestodetalles as pre')
        ->select('pre.*','ma.nombre as nom_material','u.nombre_medida')
        ->join('materiales as ma','ma.id','=','pre.material_id','inner')
        ->join('unidad_medidas as u','u.id','=','pre.unidad_medida','inner')
        ->where('pre.presupuesto_id','=',$proyecto->presupuesto->id)
        ->where('ma.categoria_id','=',$id)
        ->orderby('ma.categoria_id')
        ->get();
      }else{
        $detalles=DB::table('presupuestodetalles as pre')
        ->select('pre.*','ma.nombre as nom_material','u.nombre_medida')
        ->join('materiales as ma','ma.id','=','pre.material_id','inner')
        ->join('unidad_medidas as u','u.id','=','pre.unidad_medida','inner')
        ->where('pre.presupuesto_id','=',$proyecto->presupuesto->id)
        ->orderby('ma.categoria_id')
        ->get();
      }
      
      
        $eltbody="";
        $n=0;
        foreach($detalles as $key => $detalle):
          if($detalle->estado==1):
            $n++;
          $eltbody.='<tr>
          <td><input type="checkbox" checked data-idcambiar="'.$detalle->id.'" data-material="'.$detalle->material_id.'" data-cantidad="'.$detalle->cantidad.'" class="lositemss"></td>
              <td>'.($n).'</td>
              <td>'.$detalle->nom_material.'</td>
              <td>'.$detalle->nombre_medida.'</td>
              <td>'.$detalle->cantidad.'</td>
              <td></td>
              <td></td>
          </tr>';
          endif;
        endforeach;
      return array(1,"exito",$proyecto,$eltbody);
    }

    public function elpresupuesto($id)
    {
      $retorno=Proyecto::elpresupuesto($id);
      return $retorno;
    }

    public function empleados($id)
    {
      $retorno=Proyecto::empleados($id);
      return $retorno;
    }

    public function pagos($id)
    {
      $retorno=Proyecto::pagos($id);
      return $retorno;
    }

    public function planilla($id)
    {
      $retorno=\App\Planilla::planilla_proyecto($id);
      return $retorno;
    }

    public function generar_planilla($idproy,$id)
    {
      $retorno=Proyecto::generar_planilla($idproy,$id);
      return $retorno;
    }

    public function quitarempleado(Request $request)
    {
      try{
        $pendientes=\App\PeriodoProyecto::pendientes($request->proyecto_id);
        if(count($pendientes)==0){
          $d=\App\Detalleplanilla::find($request->id);
          $d->delete();
          return array(1,"exito");
      }else{
          return array(-2,"error","El empleado se encuentra registrado para una catorcena pendiente");
      }
      }catch(Excpetion $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public function guardarplanilla(Request $request)
    {
      try{
        DB::beginTransaction();
        for($i=0;$i<count($request->dias);$i++){
          ProyectoPlanilla::create([
            'id'=>ProyectoPlanilla::retornar_id(),
            'proyecto_id'=>$request->proyecto_id,
            'catorcena_id'=>$request->catorcena_id,
            'numero_dias'=>$request->dias[$i],
            'salario_dia'=>$request->salario_dia[$i],
            'empleado_id'=>$request->empleados[$i],
            'cargo_id'=>$request->cargo[$i]
          ]);
        }
        $catorcena=\App\PeriodoProyecto::find($request->catorcena_id);
        $catorcena->estado=2;
        $catorcena->save();
        DB::commit();
        return array(1,"exito");
      }catch(Exception $e){
        DB::rollback();
        return array(-1,"error",$e->getMessage());
      }
      


      
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

    public function portipo($tipo)
    {
      $retorno=Proyecto::portipo($tipo);
      return $retorno;
    }

    public function poranio($anio)
    {
      $retorno=Proyecto::poranio($anio);
      return $retorno;
    }

    public function calendario($id){
      $retorno=Calendarizacion::calendario($id);
      return $retorno;
    }

    public function licitacion($id)
    {
      $retorno=Licitacion::licitacion($id);
      return $retorno;
    }

    public function formulariosoli($id)
    {
      $retorno=Solicitudcotizacion::formulario_solicitud($id);
      return $retorno;
    }

    public function cambiarestado(Request $request,$id)
    {
      try{
        $proyecto=Proyecto::find($id);
        $proyecto->estado=$request->estado;
        if(isset($request->fecha_acta)):
          $proyecto->fecha_acta=date("Y-m-d H:i:s");
        endif;
        if(isset($request->motivo_pausa)):
          $proyecto->motivo_pausa=$request->motivo_pausa;
        endif;
        $proyecto->save();
        return array(1,"exito");
      }catch(Excpetion $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public function bajarlicitacion($file_name)
    {
      $file = '/proyectos/ofertas/' . $file_name;
      //dd($file);
      $disk = Storage::disk('local');
      if ($disk->exists($file)) {
          $fs = Storage::disk('local')->getDriver();
          $stream = $fs->readStream($file);
          return \Response::stream(function () use ($stream) {
              fpassthru($stream);
          }, 200, [
              "Content-Type" => $fs->getMimetype($file),
              "Content-Length" => $fs->getSize($file),
              "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
          ]);
      } else {
        return Redirect::back()->with('error', 'Archivo no encontrado');
          //abort(404, "The backup file doesn't exist.");
      }
    }

    public function bajarbase($file_name)
    {
      $file = '/proyectos/bases_licitacion/' . $file_name;
      //dd($file);
      $disk = Storage::disk('local');
      if ($disk->exists($file)) {
          $fs = Storage::disk('local')->getDriver();
          $stream = $fs->readStream($file);
          return \Response::stream(function () use ($stream) {
              fpassthru($stream);
          }, 200, [
              "Content-Type" => $fs->getMimetype($file),
              "Content-Length" => $fs->getSize($file),
              "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
          ]);
      } else {
        return Redirect::back()->with('error', 'Archivo no encontrado');
          //abort(404, "The backup file doesn't exist.");
      }
    }

    protected function validar_contrato(array $data)
    {
        $mensajes=array(
            'nombre.required'=>'El nombre del contrato es obligatorio',
            'descripcion.required'=>'La descripcion del contrato es obligatoria',
            'archivo.required'=>'Debe adjuntar el contrato',
            'archivo.mimes'=>'Debe adjuntar un archivo con extensión válida',
            'archivo.between'=>'Debe seleccionar un archivo menor a 10MB'
        );
        return Validator::make($data, [
            'nombre' => 'required',
            'descripcion'=>'required',
            'archivo'=>'required|mimes:jpeg,png,pdf,jpg,doc,docx,xls,xlsx|between:1,10000'
        ],$mensajes);

        
    }

    protected function validar_oferta(array $data)
    {
        $mensajes=array(
            'proveedor_id.required'=>'El proveedor es obligatorio',
            'archivo.required'=>'Debe adjuntar la oferta',
            'archivo.mimes'=>'Debe adjuntar un archivo con extensión válida',
            'archivo.between'=>'Debe seleccionar un archivo menor a 10MB'
        );
        return Validator::make($data, [
            'proveedor_id' => 'required',
            'archivo'=>'required|mimes:pdf,doc,docx,xls,xlsx|between:1,10000'
        ],$mensajes);

        
    }

    protected function validar_acta(array $data)
    {
        $mensajes=array(
          'descripcion.required'=>'La descripcion del acta es obligatoria',
          'archivo.required'=>'Debe adjuntar el contrato',
          'archivo.mimes'=>'Debe adjuntar un archivo con extensión válida',
          'archivo.between'=>'Debe seleccionar un archivo menor a 10MB'
      );
      return Validator::make($data, [
          'descripcion'=>'required',
          'archivo'=>'required|mimes:jpeg,png,pdf,jpg,doc,docx,xls,xlsx|between:1,10000'
      ],$mensajes);
    }

    protected function validar_base(array $data)
    {
        $mensajes=array(
          'archivo.required'=>'Debe adjuntar el contrato',
          'archivo.mimes'=>'Debe adjuntar un archivo con extensión válida',
          'archivo.between'=>'Debe seleccionar un archivo menor a 10MB'
      );
      return Validator::make($data, [
          'archivo'=>'required|mimes:pdf,doc,docx,xls,xlsx|between:1,10000'
      ],$mensajes);
    }
}
