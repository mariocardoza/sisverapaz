<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requisicione;
use App\Requisiciondetalle;
use App\Unidad;
use App\UnidadMedida;
use App\Fondocat;
use App\Cotizacion;
use DB;
use Redirect;
use Storage;
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
        return view('requisiciones.index',compact('requisiciones'));
    }

    public function porusuario()
    {
      $requisiciones = Requisicione::where('user_id',Auth()->user()->id)->where('created_at','<=',date('Y'.'-12-31'))->get();
      return view('requisiciones.porusuario',compact('requisiciones'));
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
              'fondocat_id' => $request->fondo,
              'user_id' => Auth()->user()->id,
              'observaciones' => $request->observaciones,
              'unidad_id'=>$request->unidad_id
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

    public function subir(Request $request)
    {
      /*$file= $request->file('archivo')->store('requisiciones');*/
      $request->file('archivo')->storeAs('requisiciones', $request->file('archivo')->getClientOriginalName());
      $requisicion=Requisicione::find($request->requisicion_id);
      $requisicion->nombre_archivo=$request->file('archivo')->getClientOriginalName();
      $requisicion->estado=7;
      $requisicion->save();
  
      return redirect('requisiciones/'.$requisicion->id)->with("mensaje","archivo subido con exito");
    }

    public function bajar($file_name){
      $file = '/requisiciones/' . $file_name;
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
}
