<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requisicione;
use App\ContratoRequisicione;
use App\Requisiciondetalle;
use App\Solicitudcotizacion;
use App\Unidad;
use App\UnidadMedida;
use App\Fondocat;
use App\Cotizacion;
use DB;
use Redirect;
use Storage;
use Validator;
use App\Http\Requests\RequisicionRequest;

class RequisicionController extends Controller
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
        Auth()->user()->authorizeRoles(['admin','uaci']);
        $requisiciones = Requisicione::orderBy('codigo_requisicion')->get();
        //$anios=DB::select("select  FROM requisiciones");
        
        $anios=DB::table('requisiciones')->distinct()->get(['anio']);
       //dd($los);
        return view('requisiciones.index',compact('requisiciones','anios'));
    }

    public function porusuario(Request $request)
    {
      $anios=DB::table('requisiciones')->distinct()->get(['anio']);
      $elanio=$request->get('anio');
      if($elanio != ""){
        $requisiciones = Requisicione::where('user_id',Auth()->user()->id)->where('anio','=',$elanio)->orderBy('created_at','DESC')->get();
      return view('requisiciones.porusuario',compact('requisiciones','anios','elanio'));
      }else{
        $elanio=0;
        $elanio=date('Y');
        $requisiciones = Requisicione::where('user_id',Auth()->user()->id)->where('anio','=',$elanio)->orderBy('created_at','DESC')->get();
        return view('requisiciones.porusuario',compact('requisiciones','anios','elanio'));
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      Auth()->user()->authorizeRoles(['admin','uaci','catastro','tesoreria','usuario']);
      $lasmedidas = UnidadMedida::all();
      $unidads = Unidad::all();
      foreach ($lasmedidas as $value) {
        $medidas[$value->id]=$value->nombre_medida;
      }
      $losfondos = Fondocat::where('estado',1)->get();

      foreach ($losfondos as $fondito) {
        $fondos[$fondito->id]=$fondito->categoria;
      }

      foreach ($unidads as $launidad) {
        $unidades[$launidad->id]=$launidad->nombre_unidad; 
      }



        return view('requisiciones.create',compact('medidas','fondos','unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequisicionRequest $request)
    {
        if($request->ajax())
        {
          DB::beginTransaction();
        try{
          $requisiciones = $request->requisiciones;

          $requisicion = Requisicione::create([
              'id'=>date('Yidisus'),
              'codigo_requisicion' => Requisicione::correlativo(),
              'actividad' => $request->actividad,
              'conpresupuesto'=>$request->conpresupuesto,
              'user_id' => Auth()->user()->id,
              'observaciones' => $request->observaciones == "" ? 'ninguna' : $request->observaciones,
              'unidad_id'=>$request->unidad_id,
              'anio'=>date('Y'),
              'fecha_actividad'=>invertir_fecha($request->fecha_actividad)
              ]);
            /*foreach($requisiciones as $requi){
              $elid=Requisiciondetalle::retonrar_id_insertar();
              Requisiciondetalle::create([
                'id'=>$elid,
                'cantidad' => $requi['cantidad'],
                'unidad_medida' => $requi['unidad'],
                'descripcion' => $requi['descripcion'],
                'requisicion_id' => $requisicion->id,
              ]);
            }*/
            DB::commit();
            return response()->json([
              'mensaje' => 'exito',
              'requisicion' => $requisicion->id
            ]);
        }catch (\Exception $e){
          DB::rollback();
          return response()->json([
            'mensaje' => 'error',
            'codigo' => $e->getMessage(),
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
      $unidades = UnidadMedida::all();
      foreach ($unidades as $value) {
        $medidas[$value->id]=$value->nombre_medida;
      }
      $proveedores = DB::table('proveedors')
                        ->whereRaw('estado = 1')
                        ->whereNotExists(function ($query){
                          $query->from('cotizacions')
                          ->whereRaw('cotizacions.proveedor_id = proveedors.id');
                        })->get();
        Auth()->user()->authorizeRoles(['admin','uaci','catastro','tesoreria','usuario']);
        $requisicion = Requisicione::findorFail($id);
        $elestado=Requisicione::estado_ver($id);
        return view('requisiciones.show',compact('requisicion','medidas','proveedores','elestado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $losfondos = Fondocat::where('estado',1)->get();

      foreach ($losfondos as $fondito) {
        $fondos[$fondito->id]=$fondito->categoria;
      }
      $requisicion=Requisicione::findorFail($id);
      $unidades=Unidad::pluck('nombre_unidad', 'id');
      $medidas = UnidadMedida::all();
        return view('requisiciones.edit',compact('fondos','requisicion','medidas','unidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisicione $requisicione)
    {
        $requisicione->fill($request->All());
        $requisicione->save();
        return redirect('/requisiciones')->with('mensaje','Requisición modificada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisicion $requisicione)
    {

    }

    public function portipo($tipo){
      $retorno=Requisicione::requisiciones_por_tipo($tipo);
      return $retorno;
    }

    public function poranio($anio){
      $retorno=Requisicione::requisiciones_por_anio($anio);
      return $retorno;
    }

    public function modal_agregarproducto(Request $request)
    {
      $retorno=Requisicione::modal_agregarproducto($request->all());
      return $retorno;
    }

    public function informacion($id){
      $retorno=Requisicione::informacion($id);
      return $retorno;
    }

    public function formulariosoli($id)
    {
      $retorno=Solicitudcotizacion::formulario_solicitudr($id);
      return $retorno;
    }

    public function aprobar(Request $request){
      $this->validar_aprobar($request->all())->validate();
      try{
        $requisicion=Requisicione::find($request->requisicion_id);
        $requisicion->cuenta_id=$request->cuenta_id;
        $requisicion->estado=3;
        $requisicion->save();
        return array(1,"exito");
      }catch(Exception $e){
        return array(1,"error",$e->getMessage());
      }
    }

    protected function validar_aprobar(array $data)
    {
        $mensajes=array(
            'cuenta_id.required'=>'Seleccione una cuenta para aprobar la requisición',
        );
        return Validator::make($data, [
            'cuenta_id' => 'required',

        ],$mensajes);

        
    }

    public function subircontrato(Request $request)
    {
      $this->validar_contrato($request->all())->validate();
      try{
        $request->file('archivo')->storeAs('requisiciones/contratos', $request->file('archivo')->getClientOriginalName());
        $contrato=ContratoRequisicione::create([
          'id'=>date('Yidisus'),
          'nombre'=>$request->nombre,
          'descripcion'=>$request->descripcion,
          'archivo'=>$request->file('archivo')->getClientOriginalName(),
          'requisicion_id'=>$request->requisicion_id
        ]);

        return array(1,"exito",$request->requisicion_id);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage);
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

    protected function validar_acta(array $data)
    {
        $mensajes=array(
            'archivo.required'=>'Debe adjuntar el contrato',
            'archivo.mimes'=>'Debe adjuntar un archivo con extensión válida',
            'archivo.between'=>'Debe seleccionar un archivo menor a 10MB'
        );
        return Validator::make($data, [
            'archivo'=>'required|mimes:jpeg,png,pdf,jpg,doc,docx,xls,xlsx|between:1,10000'
        ],$mensajes);

        
    }

    public function mostrar_contrato($id)
    {
      $retorno=ContratoRequisicione::mostrar_contratos($id);
      return $retorno;
    }

    public function subir(Request $request)
    {
      $this->validar_acta($request->all())->validate();
      try{
        /*$file= $request->file('archivo')->store('requisiciones');*/
      $request->file('archivo')->storeAs('requisiciones', $request->file('archivo')->getClientOriginalName());
      $requisicion=Requisicione::find($request->requisicion_id);
      $requisicion->nombre_archivo=$request->file('archivo')->getClientOriginalName();
      $requisicion->estado=7;
      $requisicion->save();
  
      return array(1,"exito",$requisicion->id);
      }catch(Excpetion $e){
        return array(-1,"error",$e);
      }
    }

    public function bajar($file_name){
      $file = 'requisiciones/' . $file_name;
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

    public function cambiarestado(Request $request,$id){
      $requisicion=Requisicione::find($id);
      try{
        $requisicion->estado=$request->estado;
        if(isset($request->fecha_acta)):
          $requisicion->fecha_acta=date("Y-m-d H:i:s");
        endif;
        $requisicion->save();
        return array(1,"exito");
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public function darbaja(Request $request){
      try{
        $requisicion=Requisicione::find($request->requisicion_id);
        $requisicion->estado=2;
        $requisicion->motivo_baja=$request->motivo_baja;
        $requisicion->fecha_baja=date('Y-m-d');
        $requisicion->save();
        return array(1,"exito");
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public function ver_cotizacion($id){
      $retorno=Cotizacion::ver_cotizacion($id);
      return $retorno;
    }

    public function materiales($id)
    {
      $retorno=Requisicione::materiales($id);
      return $retorno;
    }

    public function presupuesto($id)
    {
      $requi=Requisicione::find($id);
      $retorno=Requisicione::presupuesto($requi->user_id);
      return $retorno;
    }

    public function ver_solicitud($id)
    {
      $retorno=\App\Solicitudcotizacion::lasolicitud($id);
      return $retorno;
    }
}
