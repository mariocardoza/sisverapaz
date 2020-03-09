<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Desembolso;
use App\Cuenta;
use App\Cuentaproy;
use DB;
class DesembolsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desembolsos=Desembolso::orderBy('created_at','desc')->get();
        return view('desembolsos.index',compact('desembolsos'));
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
        $id=$request->id;
        try{
            DB::beginTransaction();
            $desembolso=Desembolso::find($id);
            if($desembolso->cuenta_id!=''){
                $total=$desembolso->monto+$desembolso->renta;
                if($total>$desembolso->cuenta->monto_inicial){
                    return array(2,"validacion",'El monto del desembolso es mayor a lo disponible en la cuenta');
                }else{
                    $desembolso->estado=3;
                    $desembolso->numero_cheque= $request->numero_cheque;
                    $desembolso->fecha_desembolso = invertir_fecha($request->fecha_desembolso);
                    $desembolso->save();

                    $cuenta=$desembolso->cuenta;
                    $otroactual=$cuenta->monto_inicial;
                    $cuenta->monto_inicial=$otroactual-$total;
                    $cuenta->save();

                    $cuentadeta=\App\CuentaDetalle::create([
                        'id'=>\App\CuentaDetalle::retonrar_id_insertar(),
                        'cuenta_id'=>$cuenta->id,
                        'accion'=>'Se pagó la cantidad de $'.$total.' por el pago de '.$desembolso->detalle,
                        'tipo'=>1,
                        'monto'=>$total
                    ]);
                    DB::commit();
                    return array(1,"exito",$desembolso->cuenta);
                }
                
            }else{

            }
            
        }catch(Exception $e){
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
}
