<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingreso;
use App\Factura;
use App\FacturaNegocio;
use App\Cuenta;
use App\CuentaDetalle;

class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $n=0;
        $n = $request->n;
        if($n==0){
            $facturas = Factura::whereEstado(1)->get();
        }else{
            $facturas = FacturaNegocio::whereEstado(1)->get();
        }
        return view('ingresos.index',\compact('facturas','n'));
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
        //
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

    public function cobro(Request $request)
    {
        if($request->tipo==1){
            $factura=Factura::find($request->id);
            \DB::beginTransaction();
            try{
                $cuenta_origen=Cuenta::where('estado',1)->where('anio',date('Y'))->where('tipo_cuenta',1)->first();
                if($cuenta_origen){
                    $cuenta_origen->monto_inicial=$cuenta_origen->monto_inicial+$factura->pagoTotal;
                    $cuenta_origen->save();

                    $detalle_origen=CuentaDetalle::create([
                        'id'=>CuentaDetalle::retonrar_id_insertar(),
                        'cuenta_id'=>$cuenta_origen->id,
                        'accion'=>'Se recibió la cantidad de $'.$factura->pagoTotal.' en concepto de cobro de impuesto correspondiente al pediodo  '.$factura->mesYear.' Para la cuenta de inmueble: '.$factura->inmueble->numero_cuenta,
                        'tipo'=>1,
                        'monto'=>$factura->pagoTotal
                    ]);

                    $cuenta_fiestas=Cuenta::where('estado',1)->where('anio',date('Y'))->where('tipo_cuenta',2)->first();
                    if($cuenta_fiestas){
                        $monto_fiestas=0;
                        $monto_fiestas=round($factura->pagoTotal*($factura->porcentajeFiestas/100),2);
                        $cuenta_fiestas->monto_inicial=$cuenta_fiestas->monto_inicial+$monto_fiestas;
                        $cuenta_fiestas->save();

                        $detalle_origen=CuentaDetalle::create([
                            'id'=>CuentaDetalle::retonrar_id_insertar(),
                            'cuenta_id'=>$cuenta_fiestas->id,
                            'accion'=>'Se recibió la cantidad de $'.$monto_fiestas.' en concepto de cobro de impuesto correspondiente al pediodo  '.$factura->mesYear.' Para la cuenta de inmueble: '.$factura->inmueble->numero_cuenta,
                            'tipo'=>1,
                            'monto'=>$monto_fiestas
                        ]);
                    }

                    
                    $factura->estado=2;
                    $factura->save();

                    \DB::commit();
                }else{
                    \DB::rollback(); 
                }
                return array(1,"exito");
            }catch(Exception $e){
                \DB::rollback();
                return array(-1,"error",$e->getMessage());
            }
        }else{
            $factura=FacturaNegocio::find($request->id);
            \DB::beginTransaction();
            try{
                $cuenta_origen=Cuenta::where('estado',1)->where('anio',date('Y'))->where('tipo_cuenta',1)->first();
                if($cuenta_origen){
                    $cuenta_origen->monto_inicial=$cuenta_origen->monto_inicial+$factura->pagoTotal;
                    $cuenta_origen->save();

                    $detalle_origen=CuentaDetalle::create([
                        'id'=>CuentaDetalle::retonrar_id_insertar(),
                        'cuenta_id'=>$cuenta_origen->id,
                        'accion'=>'Se recibió la cantidad de $'.$factura->pagoTotal.' en concepto de cobro de impuesto correspondiente al pediodo  '.$factura->mesYear.' Para la cuenta de negocio: '.$factura->negocio->numero_cuenta,
                        'tipo'=>1,
                        'monto'=>$factura->pagoTotal
                    ]);

                    $cuenta_fiestas=Cuenta::where('estado',1)->where('anio',date('Y'))->where('tipo_cuenta',2)->first();
                    if($cuenta_fiestas){
                        $monto_fiestas=0;
                        $monto_fiestas=round($factura->pagoTotal*($factura->porcentajeFiestas/100),2);
                        $cuenta_fiestas->monto_inicial=$cuenta_fiestas->monto_inicial+$monto_fiestas;
                        $cuenta_fiestas->save();

                        $detalle_origen=CuentaDetalle::create([
                            'id'=>CuentaDetalle::retonrar_id_insertar(),
                            'cuenta_id'=>$cuenta_fiestas->id,
                            'accion'=>'Se recibió la cantidad de $'.$monto_fiestas.' en concepto de cobro de impuesto correspondiente al pediodo  '.$factura->mesYear.' Para la cuenta de negocio: '.$factura->negocio->numero_cuenta,
                            'tipo'=>1,
                            'monto'=>$monto_fiestas
                        ]);
                    }

                    
                    $factura->estado=2;
                    $factura->save();

                    \DB::commit();
                }else{
                    \DB::rollback(); 
                }
                return array(1,"exito");
            }catch(Exception $e){
                \DB::rollback();
                return array(-1,"error",$e->getMessage());
            }
        }
    }
}
