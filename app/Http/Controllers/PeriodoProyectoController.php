<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodoProyecto;
use App\PagoCuenta;
use DB;
class PeriodoProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catorcenas=PeriodoProyecto::whereIn('estado',[3,4])->orderby('estado')->get();
        return view("planillaproyectos.index",compact("catorcenas"));
    }

    public function desembolso($id)
    {
        try{
            DB::beginTransaction();
            $catorcena=PeriodoProyecto::find($id);
            $total=PeriodoProyecto::calcular_total($catorcena->id);
            $proyecto=$catorcena->proyecto;
            $monto=$proyecto->cuenta->monto_inicial;
            $datos=[];
            if($monto>=$total){
                foreach($catorcena->proyectoplanilla as $c){
                    PagoCuenta::create([
                        'nombre'=>$c->empleado->nombre,
                        'nit'=>$c->empleado->nit,
                        'dui'=>$c->empleado->dui,
                        'direccion'=>$c->empleado->direccion,
                        'concepto'=>'Pago por servicios',
                        'pago'=>$c->numero_dias*$c->salario_dia,
                        'renta'=>($c->numero_dias*$c->salario_dia)*0.1,
                        'liquido'=>$c->numero_dias*$c->salario_dia-(($c->numero_dias*$c->salario_dia)*0.1),
                        'catorcena_id'=>$catorcena->id
                    ]);
                    $laplani=\App\ProyectoPlanilla::find($c->id);
                    $laplani->estado=2;
                    $laplani->save();
                }
                $catorcena->estado=4;
                $catorcena->save();

                $cuentaproy=$proyecto->cuenta;
                $ahorita=$cuentaproy->monto_inicial;
                $cuentaproy->monto_inicial=$ahorita-$total;
                $cuentaproy->save();

                $cutadetalle=\App\CuentaproyDetalle::create([
                    'id'=>date("Yididus"),
                    'cuentaproy_id'=>$cuentaproy->id,
                    'accion'=>"Pago de planilla al ".$catorcena->fecha_fin->format("d/m/Y").' del proyecto '.$proyecto->nombre,
                    'tipo'=>2,
                    'monto'=>$total
                ]);

                DB::commit();
                return array(1,"exito",$monto,$total);
            }else{
                DB::rollback();
                return array(-2,"exito","El total de la planilla $".$total." supera a lo disponible en la cuenta $".$monto,$catorcena->proyectoplanilla);
            }
        }catch(Excpetion $e){
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

    public function cambiarestado($id)
    {
        try{
            $catorna=PeriodoProyecto::find($id);
            $catorna->estado=3;
            $catorna->save();
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }
}
