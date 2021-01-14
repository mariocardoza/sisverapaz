<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContribuyenteRequest;
use App\Contribuyente;
use Carbon\Carbon;
use App\Bitacora;
use Response;
use App\Factura;
use App\FacturaNegocio;
use App\Inmueble;
use App\Negocio;
use DB;

class ContribuyenteController extends Controller
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
        $contribuyentes=Contribuyente::all();
        return view('contribuyentes.index',compact('contribuyentes'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contribuyentes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContribuyenteRequest $request)
    {
        if($request->ajax()){
            try{
               $contribuyente= Contribuyente::create([
                    'nombre'=>$request->nombre,
                    'dui'=>$request->dui,
                    'nit'=>$request->nit,
                    'sexo'=>$request->sexo,
                    'telefono'=>$request->telefono,
                    'nacimiento'=>\invertir_fecha($request->nacimiento),
                    'direccion'=>$request->direccion,
                ]);
                bitacora('Registro un contribuyente');
              return array(1,"exito",$contribuyente);
            }catch(\Exception $e){
              return response(-1,"error",$e->getMessage());
            }
        }else{
           Contribuyente::create($request->All());
            bitacora('Registro un contribuyente');
            return redirect('/contribuyentes')->with('mensaje','Registro almacenado con éxito'); 
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
        $c = Contribuyente::findorFail($id);

        return view('contribuyentes.show',compact('c'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contribuyente = Contribuyente::modal_edit($id);

        return array(1,"exito",$contribuyente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContribuyenteRequest $request, $id)
    {
        $contribuyente = Contribuyente::find($id);
        $contribuyente->nombre=$request->nombre;
        $contribuyente->nit=$request->nit;
        $contribuyente->dui=$request->dui;
        $contribuyente->sexo=$request->sexo;
        $contribuyente->direccion=$request->direccion;
        $contribuyente->nacimiento=invertir_fecha($request->nacimiento);

        $contribuyente->save();
        bitacora('Modificó un contribuyente');
        return array(1,"exito",$contribuyente);
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

    public function pagos($id)
    {
        $c=Contribuyente::findorFail($id);
        return view('contribuyentes.pagos',\compact('c'));
    }

    /* Generar pagos del contribuyente por sus inmuebles */
    public function generarPagosContribuyente(Request $request, Response $response) {
        // Verificando las fechas del sistema
        $fechaActual = date('d');
        $mesYear = date('m/Y');
  
        if(($fechaActual >= 25 && $fechaActual <= 31)){
  
          if(Factura::where('mesYear', $mesYear)->first() && FacturaNegocio::where('mesYear', $mesYear)->first()){
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
            'pagoTotal'             => 0.00,
            'porcentajeFiestas'     => DB::table('porcentajes')->where('nombre_simple','fiestas')->get()->first()->porcentaje
          );

          $factura2Array = array(
            'negocio_id'             => 0,
            'mesYear'               => date('m/Y'),
            'fechaVencimiento'       => $venci,
            'pagoTotal'             => 0.00,
            'porcentajeFiestas'     => DB::table('porcentajes')->where('nombre_simple','fiestas')->get()->first()->porcentaje
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


              /* iteracion para negocios */
              $negociosContribuyente = Negocio
                  ::where('estado', 1)
                  ->where('contribuyente_id', $value['id'])
              ->get();
              //dd($negociosContribuyente[0]->rubro);

              foreach($negociosContribuyente as $negocio){
                $total2=0;
                
                $total2=$negocio->capital*$negocio->rubro->porcentaje;

                $factura2Array["pagoTotal"]=$total2;
                $factura2Array["codigo"]=date("Yidisus");
                $factura2Array['negocio_id'] = $value['id'];
                $factura2 = \App\FacturaNegocio::create($factura2Array);
                $arrayFactura2Items = array(
                  'porcentaje'=>$negocio->rubro->porcentaje,
                  'rubro_id'=>$negocio->rubro->id,
                  'facturanegocio_id'=>$factura2->id,
                );
                //dd($factura2Array);
                $facturaitem2=\App\FacturaNegocioItem::create($arrayFactura2Items);
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

    public function baja($id,Request $r)
    {
        try{
            $contribuyente = Contribuyente::find($id);
            $contribuyente->estado=2;
            $contribuyente->motivo=$r->motivo;
            $contribuyente->fechabaja=date('Y-m-d');
            $contribuyente->save();
            bitacora('Dió de baja a un contribuyente');
            return array(1,"exito",$contribuyente);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function alta($id)
    {
        try{
            $contribuyente = Contribuyente::find($id);
            $contribuyente->estado=1;
            $contribuyente->motivo="";
            $contribuyente->fechabaja=null;
            $contribuyente->save();
            Bitacora::bitacora('Dió de alta a un contribuyente');
            return array(1,"exito",$contribuyente);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function verPagosGenerados(){
      $mesYear = date('m/Y');

      $facturas= Factura::where('mesYear',$mesYear)->get();
      // echo $facturas;
      $unidad = "Unidad de Adquicisiones Institucionales";

      $pdf = \PDF::loadView('pdf.catastro.pdfpagos',compact('facturas','unidad'));
      // $pdf->setPaper('letter', 'portrait');
      $pdf->setPaper( [0, 0, 488.165,  323.56]);
      // $pdf->render();
      //$canvas = $pdf ->get_canvas();
    //$canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      return $pdf->stream('reporte.pdf');
    }
    public function verFacturasPendientes(Request $request){
      $ids= $request['cbid'];

      $unidad = "Unidad de Adquicisiones Institucionales";

      $pdf = \PDF::loadView('pdf.catastro.pdfpendientes',compact('ids','unidad'));
      // $pdf->setPaper('letter', 'portrait');
      $pdf->setPaper( [0, 0, 488.165,  323.56]);
      // $pdf->render();
      //$canvas = $pdf ->get_canvas();
    //$canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      return $pdf->stream('reporte.pdf');
    }
}