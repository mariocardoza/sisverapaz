<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requisicione;
use App\Requisiciondetalle;
use App\Unidad;
use App\UnidadMedida;
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
        $requisiciones = Requisicione::all();
        return view('requisiciones.index',compact('requisiciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $medidas = UnidadMedida::all();
        return view('requisiciones.create',compact('medidas'));
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
              'mensaje' => 'exito'
            ]);
        }catch (\Exception $e){
          DB::rollback();
          return response()->json([
            'mensaje' => 'error',
            'codigo' => $e->getMessage(),
            'req' => $requisicion->id
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
      $requisicion=Requisicione::findorFail($id);
      $unidades=Unidad::pluck('nombre_unidad', 'id');
      $medidas = UnidadMedida::all();
        return view('requisiciones.edit',compact('requisicion','medidas','unidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisicion $requisicione)
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
