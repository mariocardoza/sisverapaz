<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Contribuyente;
use App\Inmueble;
use App\Factura;
use App\FacturasItems;
use App\Negocio;

class ContribuyenteApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contribuyente::select('id', 'nombre', 'telefono', 'dui', 'nit', 'estado')
            ->orderBy('id', 'asc')
            ->get();
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
        $all = $request->all();
        $contribuyente = new Contribuyente();

        $contribuyente->dui = $all['object']['dui'];
        $contribuyente->nit = $all['object']['nit'];
        $contribuyente->sexo = $all['object']['sexo'];
        $contribuyente->nombre = $all['object']['nombre'];
        $contribuyente->telefono = $all['object']['telefono'];
        $contribuyente->direccion = $all['object']['direccion'];
        $contribuyente->nacimiento =  date("Y-m-d", strtotime($all['object']['nacimiento']));

        if($contribuyente->save()){
          return array(
            "response"  => true,
            "data"      => $contribuyente,
            "message"   => 'Hemos agregado con exito al nuevo contribuyente',
          );
        }else{
          return array(
            "response"  => false,
            "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
          );
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
      $contribuyente  = Contribuyente::where('id', $id)
                  ->with(['inmuebles'])
                  ->take(1)
                  ->first();

      $contribuyente['negocios'] 
            = Negocio::where('contribuyente_id', $id)
              ->with(['rubro'])
              ->get();

        return $contribuyente;
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
    public function destroy(Request $request, $id)
    {
        $contribuyente = Contribuyente::find($id)->update([
            "estado" => $request->get('estado')
        ]);

        return "{ 'message' : 'Todo esta correcto' }";
    }

    public function onUpdateContribuyenteInmueble(Request $request){
        $parameters = $request->all();
        $result =  Inmueble::where('id', $parameters['id'])->update([
          'latitude'            => $parameters['lat'] ,
          'longitude'           => $parameters['lng'],
          'direccion_inmueble'  => $parameters['direccion_inmueble']
        ]);

        if($result){
            return array(
                "data"      => Inmueble::find($parameters['id']),
                "message"   => 'Hemos actualizado con exito la ubicacion',
                "response"  => true
            );
        }else{
            return array(
                "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
                "response"  => false
            );
        }
    }

    public function onUpdateContribuyente(Request $request){
      $parameters = $request->all()['people'];
      //$parameters = $parameters['people'];
      
      $result = Contribuyente::find($parameters['id'])->update([
        "nombre"      => $parameters['nombre'],
        "dui"         => $parameters['dui'],
        "nit"         => $parameters['nit'],
        "telefono"    => $parameters['telefono'],
        "direccion"   => $parameters['direccion'],
        "nacimiento"  => date("Y-m-d", strtotime($parameters['nacimiento']))
      ]);

      //$contribuyente->nacimiento =  ;
      
      if($result){
        return array(
          "data"      => Contribuyente::find($parameters['id']),
          "message"   => 'Hemos actualizado al contribuyente con exito',
          "response"  => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "response"  => false
        );
      }
        
    }

    public function darBajaContribuyente(Request $request) {
        $parameters = $request->all();
        
        $result = Contribuyente::where('id', $parameters['id'])->update([
            "fechabaja" => date('Y-m-d'),
            "motivo"    => $parameters['motivo'],
            "estado"    => $parameters['estado']
        ]);

        if($result){
            return array(
                "data"      => Contribuyente::find($parameters['id']),
                "message"   => 'Hemos actualizado con exito la ubicacion',
                "response"  => true
            );
        }else{
            return array(
                "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
                "response"  => false
            );
        }
    }


    /* Generar pagos del contribuyente por sus inmuebles */
    public function generarPagosContribuyente(Request $request, Response $response) {
      // Verificando las fechas del sistema
      $fechaActual = date('d');
      $mesYear = date('m/Y');

      if(($fechaActual >= 25 && $fechaActual <= 31)){

        if(Factura::where('mesYear', $mesYear)->first()){
          return json_encode([
            "message"   => 'No puedes ingresar 2 veces las factura de este mes',
            "error"     => true
          ], 500);
        }

        $factura= null;
        $elmes=intVal(date("m"));
        $elmes++;
        $venci=date("Y")."-".$elmes."-28";
        $facturaArray = array(
          'mueble_id'             => 0,
          'mesYear'               => date('m/Y'),
          'fechaVecimiento'       => $venci,
          'pagoTotal'             => 0.00
        );
        $este=0;
        $contribuyentesAll = Contribuyente::select('id')->get();
        $arra=[];
        foreach ($contribuyentesAll as $value) {
            $inmueblesContribuyente = Inmueble
                ::where('estado', 1)
                ->where('contribuyente_id', $value['id'])
                ->with('tipoServicio')
                ->select('id','metros_acera')
            ->get();
            
            $este++;
            foreach ($inmueblesContribuyente as $value) {
              
                $total = 0;
                $arrayFacturaItems = array();
                if(@count($value->tipoServicio) > 0){
                  $facturaArray['mueble_id'] = $value['id'];
                  
                  foreach ($value->tipoServicio as $item) {
                    $precio = ($item['isObligatorio'] == 1) ? 
                        $precio = floatval($item['costo']) : 
                        floatval($value['metros_acera']) * floatval($item['costo']);
  
                       array_push($arrayFacturaItems, new \App\FacturasItems([
                        "tipoinmueble_id" => $item->pivot['id'],
                        "precio_servicio" => $precio
                      ])); 
                      //$arra[]=$item->pivot;
                    $total += $precio;
                  }
                  $facturaArray["pagoTotal"]=$total;
                  $facturaArray["codigo"]=date("Yidisus");
                  $factura = Factura::create($facturaArray);
                  
                   $factura->items()->saveMany($arrayFacturaItems);
                }
            }
        }
        return json_encode([
            "message" => 'Peticion realizada con exito',
            "error"   => false,
            
          ]);
      }else{
        return json_encode([
          "message" => 'La fechas aceptadas para la creacion de factura es cada 25 y/o 30-31 de mes',
          "error"   => true
        ]);
      }
    }

    public function getFacturaInmuebleItems(Request $request) {
      $parameters = $request->all();
      $facturaItems = DB::table('facturas')
          ->join('inmuebles', 'facturas.mueble_id', '=', 'inmuebles.id')
          ->where('inmuebles.estado', 1)
          ->where('facturas.estado', 1)
          ->where('inmuebles.contribuyente_id', $parameters['id'])
          ->select('inmuebles.*', 'facturas.id as factura_id')
        ->get();

      return json_encode([
        "data"   => $facturaItems
      ]);
    }

    public function getFacturaItems(Request $request) {
      $parameters = $request->all();
      //$factura=Factura::where('mueble_id',$parameters['inmueble_id'])->where('id',$parameters['id'])->with('items')->first();
      return FacturasItems::where('factura_id',$parameters['id'])->with('tiposervicio')->with('factura')->get();
  //return array($factura,$items);
    }

    public function onDesactivarNegocio (Request $request) {
      $parameters = $request->all();        
      $result = Negocio::where('id', $parameters['id'])->update([
          "estado"    => $parameters['estado']
      ]);

      if($result){
        return array(
          "data"      => Negocio::find($parameters['id']),
          "message"   => 'Hemos actualizado con exito el estado',
          "ok"  => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }
}