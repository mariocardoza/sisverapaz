<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partida;
use App\Contribuyente;
use App\Cuenta;
use App\CuentaDetalle;

class PartidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partidas=Partida::all();
        $contribuyentes=Contribuyente::whereEstado(1)->get();
        return view('partidas.index',compact('partidas','contribuyentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'contribuyente' => 'required|max:100',
            'monto' => 'required|numeric|min:0.00',
        ]);

        try{
            $partida=Partida::create([
                'contribuyente'=>$request->contribuyente,
                'monto'=>$request->monto,
                'fiestas'=>\retornar_porcentaje('fiestas'),
                'total'=>$request->monto+($request->monto*retornar_porcentaje('fiestas')),
                'tipo'=>1,
            ]);
            return array(1,"exito",$partida);
        }catch(Exception $e){
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
        $partida=Partida::findorFail($id);
        return array(1,"exito",$partida);
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
        $partida=Partida::findorFail($id);
        $partida->contribuyente=$request->contribuyente;
        $partida->monto=$request->monto;
        $partida->total=$request->monto+($request->monto*retornar_porcentaje('fiestas'));
        $partida->save();
        return array(1,"exito",$partida);
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

    public function pago(Request $request)
    {
        $factura=Partida::find($request->id);
        \DB::beginTransaction();
        try{
            $cuenta_origen=Cuenta::where('estado',1)->where('anio',date('Y'))->where('tipo_cuenta',1)->first();
            if($cuenta_origen){
                $cuenta_origen->monto_inicial=$cuenta_origen->monto_inicial+$factura->monto;
                $cuenta_origen->save();

                $detalle_origen=CuentaDetalle::create([
                    'id'=>CuentaDetalle::retonrar_id_insertar(),
                    'cuenta_id'=>$cuenta_origen->id,
                    'accion'=>'Se recibió la cantidad de $'.$factura->monto.' en concepto de cobro de impuesto por emisión de partida',
                    'tipo'=>1,
                    'monto'=>$factura->monto
                ]);

                $cuenta_fiestas=Cuenta::where('estado',1)->where('anio',date('Y'))->where('tipo_cuenta',2)->first();
                if($cuenta_fiestas){
                    $monto_fiestas=0;
                    $monto_fiestas=round($factura->fiestas*$factura->monto,2);
                    $cuenta_fiestas->monto_inicial=$cuenta_fiestas->monto_inicial+$monto_fiestas;
                    $cuenta_fiestas->save();

                    $detalle_origen=CuentaDetalle::create([
                        'id'=>CuentaDetalle::retonrar_id_insertar(),
                        'cuenta_id'=>$cuenta_fiestas->id,
                        'accion'=>'Se recibió la cantidad de $'.$monto_fiestas.' en concepto de cobro de impuesto por emisión de partida',
                        'tipo'=>1,
                        'monto'=>$monto_fiestas
                    ]);
                }

                
                $factura->estado=3;
                $factura->fecha_pago=date('Y-m-d');
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
