<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuentaproy;
use App\CuentaproyDetalle;
use App\Cuenta;
use App\CuentaDetalle;
use App\Proyecto;
use App\Fondo;
use App\Http\Requests\CuentaRequest;
use App\Http\Requests\CuentauRequest;
use DB;
use Validator;

class CuentaController extends Controller
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
        $cuentas = Cuenta::all();
        return view('cuentas.index',compact('cuentas'));
    }

    public function proyectos()
    {
        $cuentas = Cuentaproy::all();
        //dd($cuentas);
        return view('cuentas.proyectos',compact('cuentas'));
    }



    public function editarproyectos(Request $request,$id)
    {
        try{
            $cuenta=Cuentaproy::find($id);
            $cuenta->fill($request->all());
            $cuenta->save();
            return array(1,"exito",$cuenta);
        }catch(Exception $e){
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
        
        return view('cuentas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CuentaRequest $request)
    {
        try{
            DB::beginTransaction();
            $cuenta=Cuenta::create([
                'nombre'=>$request->nombre,
                'monto_inicial'=>$request->monto_inicial,
                'descripcion'=>$request->descripcion,
                'banco_id'=>$request->banco_id,
                'numero_cuenta'=>$request->numero_cuenta,
                'fecha_de_apertura'=>invertir_fecha($request->fecha_de_apertura),
                'principal'=>0   
            ]);

            $detalle=CuentaDetalle::create([
                'id'=>CuentaDetalle::retonrar_id_insertar(),
                'cuenta_id'=>$cuenta->id,
                'accion'=>'Apertura de cuenta',
                'monto'=>$request->monto_inicial,
                'tipo'=>1
            ]);
            DB::commit();
            return array(1,"exito");
        }catch(Exception $e){
            DB::rollback();
            return array(-1,"error",$cuenta);
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
        $cuenta = Cuenta::findorFail($id);
        return view('cuentas.show',compact('cuenta'));
    }

    public function show2($id)
    {
        $cuenta = Cuentaproy::findorFail($id);
        return view('cuentas.show2',compact('cuenta'));
    }

    public function modal_asignar($id,$tipo)
    {
        if($tipo==2){
            $retorno=Cuentaproy::modal_asignarfondos($id);
            return $retorno;
        }else{
            $retorno=Cuenta::modal_asignarfondos($id);
            return $retorno;
        }
    }

    public function modal_remesar($id,$tipo)
    {
        if($tipo==2){
            $retorno=Cuentaproy::modal_remesar($id);
            return $retorno;
        }else{
            $retorno=Cuenta::modal_remesar($id);
            return $retorno;
        }
    }

    public function remesarcuenta(Request $request)
    {
        $this->validar_remesa($request->all())->validate();
        \DB::beginTransaction();
        try{
            CuentaDetalle::create([
                'id'=>CuentaDetalle::retonrar_id_insertar(),
                'cuenta_id'=>$request->cuenta_id,
                'accion'=>$request->detalle,
                'tipo'=>1,
                'monto'=>$request->monto
            ]);

            $cuenta=Cuenta::find($request->cuenta_id);
            $monto=$cuenta->monto_inicial;
            $cuenta->monto_inicial=$cuenta->monto_inicial+$request->monto;
            $cuenta->save();
            \DB::commit();
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function abonarcuenta(Request $request)
    {
        \DB::beginTransaction();
        try{
            $cuenta_origen=Cuenta::find($request->idcuenta);
            $monto_origen=$cuenta_origen->monto_inicial;
            $cuenta_origen->monto_inicial=$cuenta_origen->monto_inicial-$request->monto;
            $cuenta_origen->save();

            $cuenta_destino=Cuenta::find($request->cuenta_id);
            $monto_destino=$cuenta_destino->monto_inicial;
            $cuenta_destino->monto_inicial=$cuenta_destino->monto_inicial+$request->monto;
            $cuenta_destino->save();

            $detalle_origen=CuentaDetalle::create([
                'id'=>CuentaDetalle::retonrar_id_insertar(),
                'cuenta_id'=>$cuenta_origen->id,
                'accion'=>'Se tranfirió la cantidad de $'.$request->monto.' a la cuenta '.$cuenta_destino->nombre,
                'tipo'=>2,
                'monto'=>$request->monto
            ]);

            $detalle_destino=CuentaDetalle::create([
                'id'=>CuentaDetalle::retonrar_id_insertar(),
                'cuenta_id'=>$cuenta_destino->id,
                'accion'=>'Se tranfirió la cantidad de $'.$request->monto.' de la cuenta '.$cuenta_origen->nombre,
                'tipo'=>1,
                'monto'=>$request->monto
            ]);


            \DB::commit();
            return array(1,"exito",$cuenta_origen,$cuenta_destino);
        }catch(Exception $e){
            \DB::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }

    public function abonarproyecto(Request $request)
    {
        \DB::beginTransaction();
        try{
            CuentaproyDetalle::create([
                'id'=>date("Yidisus"),
                'cuentaproy_id'=>$request->cuentaproy_id,
                'accion'=>$request->accion,
                'tipo'=>$request->tipo,
                'monto'=>$request->monto,
                'acuerdo'=>$request->acuerdo,
            ]);
            
            $fondo=Fondo::find($request->elfondo);
            $actual=$fondo->monto_disponible;
            $fondo->monto_disponible=$actual-$request->monto;
            $fondo->save();

            $cuentaproy=Cuentaproy::find($request->cuentaproy_id);
            $loactual=$cuentaproy->monto_inicial;
            $cuentaproy->monto_inicial=$loactual+$request->monto;
            $cuentaproy->save();

            $cuenta=Cuenta::find($request->idcuenta);
            $otroactual=$cuenta->monto_inicial;
            $cuenta->monto_inicial=$otroactual+$request->monto;
            $cuenta->save();

            $cuentadeta=CuentaDetalle::create([
                'id'=>CuentaDetalle::retonrar_id_insertar(),
                'cuenta_id'=>$cuenta->id,
                'accion'=>'Se tranfirió la cantidad de $'.$request->monto.' a la cuenta del proyecto '.$cuentaproy->proyecto->nombre,
                'tipo'=>2,
                'monto'=>$request->monto
            ]);

            \DB::commit();
            return array(1,"exito");
        }catch(Exception $e){
            \DB::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuenta = Cuenta::findorFail($id);
        return view('cuentas.edit',compact('cuenta'));
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
        //dd($request->All());
        $cuenta->fill($request->All());
        $cuenta->save();
        return redirect('cuentas')->with('mensaje','Cuenta modificada con éxito');
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
        $id = $datos[0];
        $motivo = $datos[1];

        $cuenta = Cuenta::find($id);
        $cuenta->estado = 2;
        $cuenta->motivo = $motivo;
        $cuenta->save();
        bitacora('Dió de baja una cuenta');
        return redirect('/cuentas')->with('mensaje', 'Cuenta dada de baja');
    }

    public function alta($id)
    {
        $cuenta = Cuenta::find($id);
        $cuenta->estado = 1;
        $cuenta->motivo = "";
        $cuenta->save();
        bitacora('Dió de alta una cuenta');
        return redirect('/cuentas')->with('mensaje', 'Cuenta dada de alta');
    }

    protected function validar_remesa(array $data)
    {
        $mensajes=array(
            'monto.required'=>'El monto a remesar es obligatorio',
            'monto.min'=>'El monto a remesar debe ser mayor a cero',
            'detalle.required'=>'El detalle es obligatorio'
        );
        return Validator::make($data, [
            'monto' => 'required|numeric',
            'detalle'=>'required'
        ],$mensajes);

        
    }
}
