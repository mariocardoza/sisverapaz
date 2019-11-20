<?php

namespace App\Http\Controllers;
// set_time_limit(300);
use Illuminate\Http\Request;
use App\Contribuyente;

class ReportesUaciController extends Controller
{
    public function proyectos()
    {
    	$proyectos = \App\Proyecto::all();
    	$tipo = "REPORTE DE PROYECTOS";
    	$pdf = \PDF::loadView('pdf.uaci.proyecto',compact('proyectos','tipo'));
   		$pdf->setPaper('letter', 'portrait');
  		return $pdf->stream('proyectos.pdf');
    }

    public function proveedor()
    {
    	$proveedores = \App\Proveedor::where('estado',1)->get();
    	$tipo = "REPORTE DE PROVEEDORES";
    	$pdf = \PDF::loadView('pdf.uaci.proveedor',compact('proveedores','tipo'));
    	$pdf->setPaper('letter', 'landscape');
    	return $pdf->stream('proveedores.pdf');
    }

    public function cotizaciones($id)
    {
      $requisicion = \App\Requisicione::findorFail($id);
      $tipo = "REPORTE DE COTIZACIONES";
    	$pdf = \PDF::loadView('pdf.uaci.cotizaciones',compact('tipo','requisicion'));
    	$pdf->setPaper('letter', 'landscape');
    	return $pdf->stream('cotizaciones.pdf');
    }

    public function solicitud($id)
    {
    	$solicitud = \App\Solicitudcotizacion::findorFail($id);
      $configuracion=\App\Configuracion::first();
      if($solicitud->tipo==1)
      {
        $tipo = "SOLICITUD DE COTIZACION DE BIENES Y SERVICIOS";
      	$pdf = \PDF::loadView('pdf.uaci.solicitud',compact('solicitud','tipo','configuracion'));
      	$pdf->setPaper('letter', 'portrait');
      	return $pdf->stream('solicitud.pdf');
      }else{
        $tipo = "SOLICITUD DE COTIZACION DE BIENES Y SERVICIOS POR LIBRE GESTION";
      	$pdf = \PDF::loadView('pdf.uaci.solicitud',compact('solicitud','tipo','configuracion'));
      	$pdf->setPaper('letter', 'portrait');
      	return $pdf->stream('solicitud.pdf');
      }

    }

    public function ordencompra($id)
    {
    	$ordencompra = \App\Ordencompra::findorFail($id);
    	//dd($ordencompra);
    	$tipo = "ORDEN DE COMPRA";
    	$pdf = \PDF::loadView('pdf.uaci.ordencompra',compact('ordencompra','tipo'));
    	$pdf->setPaper('letter','portrait');
    	return $pdf->stream('ordencompra.pdf');
    }

    public function planillaproyecto($id)
    {
      $catorcena=\App\PeriodoProyecto::find($id);
      $tipo="Planilla por proyecto:<b> ".$catorcena->proyecto->nombre."</b>";
      
      $pdf=\PDF::loadView('pdf.uaci.planilla',compact('catorcena','tipo'));
      $pdf->setPaper('letter','landscape');
      return $pdf->stream('planilla.pdf');
    }

    public function asistenciaproyecto($id)
    {
      $proyecto=\App\Proyecto::find($id);
      $tipo="Control de asistencia del proyecto:<b> ".$proyecto->nombre."</b> del ".$proyecto->periodoactivo[0]->fecha_inicio->format("d/m/Y")." al ".$proyecto->periodoactivo[0]->fecha_fin->format("d/m/Y");
      
      $pdf=\PDF::loadView('pdf.uaci.asistenciaproyecto',compact('proyecto','tipo'));
      $pdf->setPaper('letter','landscape');
      return $pdf->stream('asistencia.pdf');
    }

    public function acta($id)
    {
      $orden = \App\Ordencompra::findorFail($id);
      $configuracion = \App\Configuracion::first();
      $tipo = "ACTA DE ENTREGA Y RECEPCIÓN DE BIENES Y SERVICIOS";
      $pdf = \PDF::loadview('pdf.uaci.acta',compact('orden','tipo','configuracion'));
      $pdf->setPaper('letter','portrait');
      return $pdf->stream('acta.pdf');
    }

    public function cuadrocomparativo($id)
    {
    	$solicitud = \App\PresupuestoSolicitud::where('estado',2)->findorFail($id);
        $presupuesto = \App\Presupuesto::findorFail($solicitud->presupuesto->id);
        //dd($presupuesto);
        $detalles = \App\Presupuestodetalle::where('presupuesto_id',$presupuesto->id)->get();
        $cotizaciones = \App\Cotizacion::where('presupuestosolicitud_id',$solicitud->id)->with('detallecotizacion')->get();
        //dd($cotizaciones);
    	$tipo = "REPORTE DE CUADRO COMPARATIVO DE OFERTAS";
    	$pdf = \PDF::loadView('pdf.uaci.cuadrocomparativo',compact('solicitud','presupuesto','detalles','cotizaciones','tipo'));
    	$pdf->setPaper('letter','landscape');
    	return $pdf->stream('cuadrocomparativo.pdf');
    }

    public function cuadrocomparativo2($id)
    {
    	$solicitud = \App\Solicitudcotizacion::findorFail($id);
        $presupuesto = \App\Presupuesto::findorFail($solicitud->presupuesto->id);
        //dd($presupuesto);
        $detalles = \App\Presupuestodetalle::where('presupuesto_id',$presupuesto->id)->get();
        $cotizaciones = \App\Cotizacion::where('presupuestosolicitud_id',$solicitud->id)->with('detallecotizacion')->get();
        //dd($cotizaciones);
    	$tipo = "REPORTE DE CUADRO COMPARATIVO DE OFERTAS";
    	$pdf = \PDF::loadView('pdf.uaci.cuadrocomparativo2',compact('solicitud','presupuesto','detalles','cotizaciones','tipo'));
    	$pdf->setPaper('letter','landscape');
    	return $pdf->stream('cuadrocomparativo.pdf');
    }

    public function contratoproyecto($id)
    {
        $alcaldia=\App\Configuracion::first();
        $contratacionproyecto = \App\ContratacionProyecto::findorFail($id);
        $tipo = "CONTRATO DE EMPLEADO";
        $pdf = \PDF::loadView('pdf.uaci.contratacionproyecto',compact('contratacionproyecto','tipo','alcaldia'));
        $pdf->setPaper('letter','portrait');
        return $pdf->stream('contratacionproyecto.pdf');
    }

    public function requisicionobra($id)
    {
      $configuracion=\App\Configuracion::first();
      $requisicion = \App\Requisicione::findorFail($id);
      $tipo = "REQUISICIÓN DE OBRAS, BIENES Y SERVICIOS";
      
      $pdf = \PDF::loadView('pdf.uaci.requisicionobra',  compact('requisicion','tipo','configuracion'));
      $pdf->setPaper('letter', 'portrait');
      return $pdf->stream('requisicionobra.pdf');
    }

    public function reportePDF()
    {
      //$contribuyentes = Contribuyente::take(10)->get();
      $contribuyentes = Contribuyente::all();
      $configuracion=\App\Configuracion::first();
      // $requisicion = \App\Requisicione::findorFail($id);
      $tipo = "Contribuyentes";
      
      $pdf = \PDF::loadView('pdf.reporte.contribuyentes',  compact('contribuyentes', 'configuracion'));
      $pdf->setPaper('letter', 'portrait');
      return $pdf->stream('contribuyentes.pdf');
    }

    public function presupuestounidad($id)
    {
      $presupuesto = \App\Presupuestounidad::find($id);
      $tipo = "PRESUPUESTO DE UNIDADES";
      $pdf = \PDF::loadView('pdf.uaci.presupuestounidad',compact('presupuesto','tipo'));
      $pdf->setPaper('letter', 'portrait');
      return $pdf->stream('presupuestounidad.pdf');
    }
}
