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
use Illuminate\Database\Eloquent\Collection;
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
                    //'numero_cuenta' => Contribuyente::count() == 0 ? 'CT' . sprintf('%05d', 1) : 'CT' . sprintf('%05d', Contribuyente::get()->last()->id + 1),
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

    public function verpagos($id)
    {
        $inmueble=Inmueble::findorFail($id);
        return view('contribuyentes.verpagos',\compact('inmueble'));
    }

    public function verpagosn($id)
    {
        $negocio=Negocio::findorFail($id);
        return view('contribuyentes.verpagosn',\compact('negocio'));
    }

    /* Generar pagos del contribuyente por sus inmuebles */
    public function generarPagosContribuyente(Request $request, Response $response) {
        // Verificando las fechas del sistema
        $fechaActual = date('d');
        $mesYear = date('m/Y');
        //$mesYear='02/2020';
  
        if(($fechaActual >= 1 && $fechaActual <= 31)){
  
          if(Factura::where('mesYear', $mesYear)->first() && FacturaNegocio::where('mesYear', $mesYear)->first()){
            return json_encode([
              "message"   => 'No puedes ingresar 2 veces las factura de este mes',
              "error"     => true
            ], 500);
          }
  
          $factura= null;
          $elmes=intVal(date("m"));
          if($elmes==12){
            $elmes=0;
          }
          $elmes++;
          $venci=date("Y")."-".$elmes."-28";
          $facturaArray = array(
            'mueble_id'             => 0,
            'mesYear'               => date('m/Y'),
            'fechaVencimiento'       => $venci,
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

              //// calcular si aplica mora al inmueble
              //Inmueble::aplicar_mora($value->id);
                
                  $total = 0;
                  $arrayFacturaItems = array();
                  if(@count($value->tipoServicio) > 0){
                    $facturaArray['mueble_id'] = $value['id'];
                    
                    foreach ($value->tipoServicio as $item) {
                      if($item['estado']==1):
                        $precio = ($item['isObligatorio'] == 1) ? 
                            $precio = floatval($item['costo']) : 
                            floatval($value['metros_acera']) * floatval($item['costo']);
      
                          array_push($arrayFacturaItems, new \App\FacturasItems([
                            "tipoinmueble_id" => $item->pivot['id'],
                            "precio_servicio" => $precio
                          ])); 
                          //$arra[]=$item->pivot;
                        $total += $precio;
                      endif;
                    }
                    $subt=0;
                    $subt=$this->getMora($value->id) + $total; 
                    $facturaArray["pagoTotal"]=$subt;
                    $facturaArray["subTotal"]=$total;
                    $facturaArray["mora"]=$this->getMora($value->id);
                    $facturaArray["codigo"]=rand(1000000000,9999999999);
                    $factura = Factura::create($facturaArray);
                    
                     $factura->items()->saveMany($arrayFacturaItems);
                     //aplicar mora
                     //Inmueble::aplicar_mora($factura->id);
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
                $subt=0;
                $subt=$this->getMoraNegocio($negocio->id) + $total2; 
                $factura2Array["subTotal"]=$total2;
                $factura2Array["pagoTotal"]=$subt;
                $factura2Array["codigo"]=rand(1000000000,9999999999);
                $factura2Array['negocio_id'] = $negocio['id'];
                $factura2Array['mora'] = $this->getMoraNegocio($negocio->id);
                $factura2Array['intereses'] = 0;
                
                $factura2 = \App\FacturaNegocio::create($factura2Array);
                $arrayFactura2Items = array(
                  'porcentaje'=>$negocio->rubro->porcentaje,
                  'rubro_id'=>$negocio->rubro->id,
                  'facturanegocio_id'=>$factura2->id,
                );
                //dd($factura2Array);
                $facturaitem2=\App\FacturaNegocioItem::create($arrayFactura2Items);
                /// calcular si aplica mora al negocio
                //Negocio::aplicar_mora($factura2->id);
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
      $unidad = "Catastros";

      $pdf = \PDF::loadView('pdf.catastro.pdfpagos',compact('facturas','unidad'));
      // $pdf->setPaper('letter', 'portrait');
      $pdf->setPaper( [0, 0, 488.165,  323.56]);
      // $pdf->render();
      //$canvas = $pdf ->get_canvas();
    //$canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      return $pdf->stream('reporte.pdf');
    }

    public function verPagosNegociosGenerados(){
      $mesYear = date('m/Y');

      $facturas= FacturaNegocio::where('mesYear',$mesYear)->get();
      // echo $facturas;
      $unidad = "Catastros";

      $pdf = \PDF::loadView('pdf.catastro.pdfpagosnegocios',compact('facturas','unidad'));
      // $pdf->setPaper('letter', 'portrait');
      $pdf->setPaper( [0, 0, 488.165,  323.56]);
      // $pdf->render();
      //$canvas = $pdf ->get_canvas();
    //$canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      return $pdf->stream('reporte.pdf');
    }

    public function verFacturasPendientes(Request $request){
      $ids= $request['cbid'];
      if(!is_array($ids)){
        $ids = array(
          0 => $ids,
        );
      }
      $unidad = "Unidad de Adquicisiones Institucionales";

      $pdf = \PDF::loadView('pdf.catastro.pdfpendientes',compact('ids','unidad'));
      // $pdf->setPaper('letter', 'portrait');
      $pdf->setPaper( [0, 0, 488.165,  323.56]);
      // $pdf->render();
      //$canvas = $pdf ->get_canvas();
    //$canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      return $pdf->stream('reporte.pdf');
    }

    public function verFacturasPendientesn(Request $request){
      $ids= $request['cbid'];
      if(!is_array($ids)){
        $ids = array(
          0 => $ids,
        );
      }
      $unidad = "Unidad de Adquicisiones Institucionales";

      $pdf = \PDF::loadView('pdf.catastro.pdfpendientesn',compact('ids','unidad'));
      // $pdf->setPaper('letter', 'portrait');
      $pdf->setPaper( [0, 0, 488.165,  323.56]);
      // $pdf->render();
      //$canvas = $pdf ->get_canvas();
    //$canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      return $pdf->stream('reporte.pdf');
    }

    public function recibosn($id)
    {
      $negocio = Negocio::find($id);
      return view('contribuyentes.recibosn',compact('negocio'));
    }

    private function getMora($inmueble_id){
      $pending_maintenances = Factura::where('mueble_id', $inmueble_id)
        ->where('estado', 1)
        ->get();
      return el_porcentaje('mora') * $pending_maintenances->count();
    }

    private function getMoraNegocio($negocio_id){
      $pending_maintenances = FacturaNegocio::where('negocio_id', $negocio_id)
        ->where('estado', 1)
        ->get();
      return el_porcentaje('mora') * $pending_maintenances->count();
    }

    public function solvencia($id)
    {
      $solvente=true;
      $mensaje="";
      $contribuyente = Contribuyente::find($id);
      $negocios = $contribuyente->negocio;
      $inmuebles = $contribuyente->inmueble;
      $dn=0;$di=0;
      foreach($contribuyente->negocios as $negocio){
        foreach($negocio->factura as $factura){
          if($factura->estado==1){
            $dn++;
          }
        }
      }
      foreach($inmuebles as $inmueble){
        foreach($inmueble->factura as $factura){
          if($factura->estado==1){
            $di++;
          }
        }
      }
      if($dn==0 & $di==0){
        $solvente=true;
      }else{
        $solvente=false;
        $mensaje = 'Aún posee deuda con la alcaldía, no es posible emitir la solvencia';
      }
      return array(1,"exito",$solvente,$mensaje);
    }

    public function pdfsolvencia($id){
      $contribuyente = Contribuyente::find($id);

      $pdf = \PDF::loadView('pdf.catastro.pdfsolvencia',compact('contribuyente'));
      // $pdf->setPaper('letter', 'portrait');
      $pdf->setPaper('letter', 'portrait');
      // $pdf->render();
      //$canvas = $pdf ->get_canvas();
    //$canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
      return $pdf->stream('solvencia.pdf');
    }

    public function morosos(Request $request)
    {
      $negocios = Negocio::whereEstado(1)->get();
      $inmuebles = Inmueble::whereEstado(1)->get();
      //$morosos = array();
      $coleccion = array();
      if($request->type==2 ):
        $morosos = array();
        foreach($negocios as $negocio){
          foreach($negocio->factura as $factura){
            if($factura->estado==1){
              $morosos['contribuyente'] = $negocio->contribuyente->nombre;
              $morosos['direccion'] = $negocio->contribuyente->direccion;
              $morosos['nit'] = $negocio->contribuyente->nit;
              $morosos['id'] = $negocio->contribuyente->id;
              $morosos['detalle'] = 'Negocio: '.$negocio->nombre;
              $morosos['periodo'] = $factura->mesYear;
              $morosos['deuda'] = $factura->pagoTotal;
              array_push($coleccion, $morosos);
            }
            
          }
        }
      else:
        $morosos = array();
        foreach($inmuebles as $inmueble){
          foreach($inmueble->factura as $factura){
            if($factura->estado==1){
              $morosos['contribuyente'] = $inmueble->contribuyente->nombre;
              $morosos['direccion'] = $inmueble->contribuyente->direccion;
              $morosos['nit'] = $inmueble->contribuyente->nit;
              $morosos['id'] = $inmueble->contribuyente->id;
              $morosos['detalle'] = 'Inmueble n°: '.$inmueble->numero_escritura;
              $morosos['periodo'] = $factura->mesYear;
              $morosos['deuda'] = $factura->pagoTotal;
              array_push($coleccion, $morosos);
            }
            
          }
        }
      endif;
      return view('contribuyentes-morosos.index',compact('coleccion'));
    }
}