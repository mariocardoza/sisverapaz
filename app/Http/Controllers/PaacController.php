<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaacRequest;
use App\Paac;
use App\Paacdetalle;
use DB;

class PaacController extends Controller
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
    public function index()
    {
      $paacs = Paac::all();
        return view('paacs.index',compact('paacs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //formulario para registrar plan anual
    public function crear()
    {
      return view('paacs.crear');
    }

    public function guardar(Request $request)
    {
        Paac::create($request->All());
        return redirect('paacs')->with('mensaje','Registrado con exito');
    }
    public function create()
    {
        $anio = date('Y');
        $paacs = Paac::where('anio',$anio)->get();
        return view('paacs.create',compact('paacs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaacRequest $request)
    {
      DB::beginTransaction();
      try{
      $count = $request->contador;
      $paac = Paac::findorFail($request->paac_id);
      $total=$paac->total;
      $paac->total=$total+$request->total;
      $paac->save();

      for($i = 0; $i<$count;$i++){
        Paacdetalle::create([
          'obra' => $request->obras[$i],
          'paac_id' => $paac->id,
          'enero' => $request->enero[$i],
          'febrero' => $request->febrero[$i],
          'marzo' => $request->marzo[$i],
          'abril' => $request->abril[$i],
          'mayo' => $request->mayo[$i],
          'junio' => $request->junio[$i],
          'julio' => $request->julio[$i],
          'agosto' => $request->agosto[$i],
          'septiembre' => $request->septiembre[$i],
          'octubre' => $request->octubre[$i],
          'noviembre' => $request->noviembre[$i],
          'diciembre' => $request->diciembre[$i],
          'subtotal' => $request->totales[$i],
        ]);
      }
      DB::commit();
        return redirect('/paacs')->with('mensaje','Plan registrado con éxito');
      }catch (\Exception $e){
        DB::rollback();
        return redirect('/paacs/create')->with('error','Error al registrar el plan '.$e->getMessage());
  }

      //dd($total);
      //\DB::select('SELECT paac(?,?,?)',array($request->anio,$request->total,$request->obra));
      return redirect('paacs')->with('mensaje','Paac exitoso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $paac=Paac::findorFail($id);
      $detalles = Paacdetalle::where('paac_id',$paac->id)->orderBy('id','ASC')->get();
        return view('paacs.show',compact('paac','detalles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Paac $paac)
    {
        return view('paacs.edit',compact('paac'));
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
        $paac=Paac::find($id);
        $paac->fill($request->All());
        return redirect('paacs')->with('mensaje','Plan actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $paac=Paac::findorFail($id);
      try{
        $paac->delete();
        return response()->json([
          'mensaje' => 'exito'
        ]);
      }catch(Exception $e){
        return response()->json([
          'mensaje' => $e->getMessage()
        ]);
      }
    }


}
