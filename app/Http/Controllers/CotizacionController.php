<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;
use App\Proveedor;
use App\Cotizacion;
use App\Detallecotizacion;
use App\Bitacora;
use App\Presupuesto;
use DB;
use App\Http\Requests\CotizacionRequest;

class CotizacionController extends Controller
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
        if($estado == "" )$estado=1;
        if ($estado == 1) {
            $cotizaciones = Cotizacion::where('estado',$estado)->get();
            return view('cotizaciones.index',compact('cotizaciones','estado'));
        }
        if ($estado == 2) {
            $cotizaciones = Cotizacion::where('estado',$estado)->get();
            return view('cotizaciones.index',compact('cotizaciones','estado'));
        }
    }

    public function cuadros()
    {
        $proyectos = Proyecto::where('estado',3)->where('presupuesto',true)->with('presupuesto')->get();
        return view('cotizaciones.cuadros',compact('proyectos'));
    }

    public function cotizar($id)
    {
        //return $cotizaciones = Cotizacion::where('proyecto_id',$id)->with('proveedor')->get();
        $proyecto = Proyecto::where('estado',3)->where('presupuesto',true)->findorFail($id);
        $presupuesto = Presupuesto::where('proyecto_id',$proyecto->id)->with('presupuestodetalle')->first();
        $cotizaciones = Cotizacion::where('presupuesto_id',$presupuesto->id)->with('detallecotizacion')->get();
        return view('cotizaciones.cotizar',compact('proyecto','presupuesto','cotizaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyectos = Proyecto::where('estado',3)->where('presupuesto',true)->get();
        $proveedores = Proveedor::where('estado',1)->get();
        $cotizaciones = Cotizacion::all();
        return view('cotizaciones.create',compact('proyectos','proveedores','cotizaciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->All());

        DB::beginTransaction();
        try
        {
          $presupuesto = Presupuesto::where('proyecto_id',$request->proyecto_id)->first();
            $count = count($request->precios);
            $cotizacion = Cotizacion::create([
                'proveedor_id' => $request->proveedor_id,
                'presupuesto_id' => $presupuesto->id,
                'descripcion' => $request->descripcion,
            ]);
            for($i=0;$i<$count;$i++)
            {
                Detallecotizacion::create([
                    'cotizacion_id' => $cotizacion->id,
                    'descripcion' => $request->descripciones[$i],
                    'marca' => $request->marcas[$i],
                    'unidad_medida' => $request->unidades[$i],
                    'cantidad' => $request->cantidades[$i],
                    'precio_unitario' => $request->precios[$i],
                ]);
            }
            DB::commit();
            bitacora('Registró una cotización');
            return redirect('/cotizaciones')->with('mensaje','Registro almacenado con éxito');
        }catch (\Exception $e){
            DB::rollback();
            return redirect('/cotizaciones/create')->with('error',$e->getMessage());
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
        $cotizacion = Cotizacion::where('estado',1)->findorFail($id);

        return view('cotizaciones.show', compact('cotizacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cotizacion = Cotizacion::findorFail($id);
        return view('cotizaciones.edit',compact('cotizacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(CotizacionRequest $request, $id)
    {
        $cotizacion = Cotizacion::find($id);
        $cotizacion->fill($request->All());
        $cotizacion->save();
        bitacora('Modificó una cotización');
        return redirect('/cotizaciones')->with('mensaje','Registro modificado con éxito');
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

        $datos = explode("+", $cadena);
        $id=$datos[0];
        $motivo=$datos[1];
        $cotizacion = Cotizacion::find($id);
        $cotizacion->estado=2;
        $cotizacion->motivo=$motivo;
        $cotizacion->fechabaja=date('Y-m-d');
        $cotizacion->save();
        bitacora('Dió de baja a un cotizacion');
        return redirect('/cotizaciones')->with('mensaje','Cotización dada de baja');
    }

    public function alta($id)
    {
        $cotizacion = Cotizacion::find($id);
        $cotizacion->estado=1;
        $cotizacion->motivo=null;
        $cotizacion->fechabaja=null;
        $cotizacion->save();
        Bitacora::bitacora('Dió de alta a un cotizacion');
        return redirect('/cotizaciones')->with('mensaje','Cotización dada de alta');
    }
}
