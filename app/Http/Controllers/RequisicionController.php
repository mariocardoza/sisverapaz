<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requisicione;
use App\Requisiciondetalle;
use App\Unidad;
use App\UnidadMedida;
use App\Fondocat;
use DB;
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
        Auth()->user()->authorizeRoles('admin');
        $requisiciones = Requisicione::all();
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
      $medidas = UnidadMedida::all();
      $fondos = Fondocat::where('estado',1)->get();

        return view('requisiciones.create',compact('medidas','fondos'));
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
              'codigo_requisicion' => Requisicione::correlativo(),
              'actividad' => $request->actividad,
              'fondocat_id' => $request->fondo,
              'user_id' => $request->user_id,
              'observaciones' => $request->observaciones,
              ]);
            foreach($requisiciones as $requi){
              Requisiciondetalle::create([
                'cantidad' => $requi['cantidad'],
                'unidad_medida' => $requi['unidad'],
                'descripcion' => $requi['descripcion'],
                'requisicion_id' => $requisicion->id,
              ]);
            }
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
      Auth()->user()->authorizeRoles(['admin','uaci','catastro','tesoreria','usuario']);
        $requisicion = Requisicione::findorFail($id);
        //$detalles = Requisiciondetalle::where('requisicion_id',$requisicion->id)->get();
        //dd($requisicion);
        return view('requisiciones.show',compact('requisicion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $fondos = Fondocat::where('estado',1)->get();
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
}
