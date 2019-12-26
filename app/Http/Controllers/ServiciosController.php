<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;
use App\ServiciosPago;
use App\Cuenta;
use App\CuentaDetalle;
use DB;
use Validator;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios=Servicio::whereEstado(1)->get();
        return view('servicios.index', compact('servicios'));
    }

    public function pagos()
    {
        $pagados=ServiciosPago::all();

        return view('servicios.pagos',compact('pagados'));
    }

    public function pagar_servicio(Request $request)
    {
        $this->validar_pago($request->all())->validate();
        try{
            DB::beginTransaction();
            $elpago=ServiciosPago::create([
                'id'=>date("Yidisus"),
                'cuenta_id'=>$request->cuenta_id,
                'servicio_id'=>$request->servicio_id,
                'monto'=>$request->monto,
                'fecha_pago'=>invertir_fecha($request->fecha_pago),
                'anio'=>$request->anio,
                'mes'=>$request->mes
            ]);
            $servi=Servicio::find($request->servicio_id);

            $cuenta_origen=Cuenta::find($request->cuenta_id);
            $monto_origen=$cuenta_origen->monto_inicial;
            $cuenta_origen->monto_inicial=$monto_origen-$request->monto;
            $cuenta_origen->save();

            $detalle_destino=CuentaDetalle::create([
                'id'=>CuentaDetalle::retonrar_id_insertar(),
                'cuenta_id'=>$cuenta_origen->id,
                'accion'=>'Se pago la cantidad de $'.$request->monto.' correspondiente al pago del servicio: '.$servi->nombre.' del mes de '.$request->mes,
                'tipo'=>1,
                'monto'=>$request->monto
            ]);
            DB::commit();
            return array(1,"exito");
        }catch(Exception $e){
            DB::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar($request->all())->validate();
        try{
            Servicio::create($request->all());
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'nombre.required'=>'El nombre del servicio es obligatorio',
            'fecha_contrato.required'=>'La fecha de contratación es obligatoria'
        );
        return Validator::make($data, [
            'nombre' => 'required',
            'fecha_contrato' => 'required',
        ],$mensajes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    protected function validar_pago(array $data)
    {
        $mensajes=array(
            'cuenta_id.required'=>'Seleccione una cuenta',
            'servicio_id.required'=>'Seleccione una servicio a pagar',
            'monto.required'=>'El monto es obligatorio',
            'anio.required'=>'El año es obligatorio',
            'fecha_pago.required'=>'La fecha de pago es obligatorio',
        );
        return Validator::make($data, [
            'cuenta_id' => 'required',
            'servicio_id' => 'required',
            'monto' => 'required',
            'anio' => 'required',
            'fecha_pago' => 'required',
        ],$mensajes);

        
    }
}
