<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendarizacion;
use DB;
use Carbon\Carbon;

class CalendarizacionController extends Controller
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
        $calendarizaciones = Calendarizacion::all();
        return view('calendarizaciones.index',compact('calendarizaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendarizaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
        DB::beginTransaction();
        $i=Carbon::createFromFormat('d/m/Y H:i', $request->inicio)->toDateTimeString();
        $f=Carbon::createFromFormat('d/m/Y H:i', $request->fin)->toDateTimeString();
        Calendarizacion::create([
          'evento'=>$request->evento,  
          'descripcion'=>$request->descripcion,  
          'inicio'=>$i,
          'fin'=>$f,
          'proyecto_id'=>$request->proyecto_id
        ]);

        $proyecto=\App\Proyecto::find($request->proyecto_id);
        $proyecto->estado=2;
        $proyecto->save();
        DB::commit();
        return array(1,"exito");
        }
        catch(Exception $e){
            DB::rollBack();
            return array(-1,"error",$e->getMessage());
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
        $calendarizacion = Calendarizacion::findorFail($id);
        return view('calendarizaciones.show',compact('calendarizacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $calendarizacion = Calendarizacion::findorFail($id);
        return view('calendarizaciones.edit',compact('calendarizacion'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $cal=Calendarizacion::find($id);
            $cal->delete();
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function agregar_calendarizacion(Request $request){
        $cal = Calendarizacion::create($request->All());
    }
}