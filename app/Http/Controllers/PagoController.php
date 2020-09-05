<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipopago;
use App\Cuenta;
//use App\Cuentaproy;
use App\Contribuyente;
use App\Factura;
use App\Bitacora;
//use App\Http\Requests\ContratoRequest;

class PagoController extends Controller
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

    public function index(Request $request)
    {
         //$facturas = Factura::orderBy('created_at','desc')->get();
         return view('pagos.index');
    }

    //public function guardarCuenta(Request $request)
    //{
      //  if($request->ajax())
        //{
          //  Cuentaproy::create($request->All());
            //return response()->json([
              //  'mensaje' => 'Registro creado']
            //);
        //}
    //}

        public function listarCuentas()
        {
            return Cuenta::where('estado',1)->get();
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipopagos = Tipopago::where('estado',1);
        //$cuentas = Cuentaproy::all();
        $contribuyentes = Contribuyente::where('estado', 1)->get();
        $pagos = Pago::where('estado',1)->get();
        return view('pagos.create',compact('tipopagos','contribuyentes','pagos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $params = $request->all();
        // Pago::create($request->All());

        $data = $request->all();        
        Pago::create([
            'tipopago_id'       => $data['tipopago_id'],
            'monto'             => $data['monto'],
            'cuenta_id'         => '7',
            'num_factura'       => $data['num_factura'], 
            'contribuyente_id'  => $data['contribuyente_id'],
        ]);
        bitacora('Registró un pago de factura');
        $retorno = factura::guardar($request->All());
        return $retorno;
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
        $factura = Factura::find($id);
        return array(1,"exitoso",$factura);
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
        try{
            $factura = Factura::find($id);
            if($factura->nombre!= $request->nombre)
            {
                $this->validate($request,['nombre' => 'required|unique:factura|min:5']);
            }
            $pago->nombre = $request->nombre;
            $pago->save();
            return array(1,"éxito");
        } catch(exception $e){
            return array(-1);
        }
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
