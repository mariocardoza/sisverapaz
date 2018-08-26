<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function solicitud($id)
    {
    	$solicitud = \App\PresupuestoSolicitud::findorFail($id);
    	$presupuesto = \App\Presupuesto::where('categoria_id', "=", $solicitud->categoria_id)->firstorFail();
    	$tipo = "SOLICITUD DE COTIZACION DE BIENES Y SERVICIOS POR LIBRE GESTION";
    	$pdf = \PDF::loadView('pdf.uaci.solicitud',compact('solicitud','tipo','presupuesto'));
    	$pdf->setPaper('letter', 'portrait');
    	return $pdf->stream('solicitud.pdf');
    }

    public function ordencompra($id)
    {
    	$ordencompra = \App\Ordencompra::findorFail($id);
    	//dd($ordencompra);
    	$tipo = "REPORTE DE ORDEN DE COMPRA";
    	$pdf = \PDF::loadView('pdf.uaci.ordencompra',compact('ordencompra','tipo'));
    	$pdf->setPaper('letter','portrait');
    	return $pdf->stream('ordencompra.pdf');
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

    public function contratoproyecto($id)
    {
        $alcaldia=\App\Configuracion::first();
        $contratacionproyecto = \App\ContratacionProyecto::findorFail($id);
        $tipo = "CONTRATO DE EMPLEADO";
        $pdf = \PDF::loadView('pdf.uaci.contratacionproyecto',compact('contratacionproyecto','tipo','alcaldia'));
        $pdf->setPaper('letter','portrait');
        return $pdf->stream('contratacionproyecto.pdf');
    }

    public function requisicionobra()
    {
        $requisicionobra = \App\Requision::all();
        $tipo = "REQUISICIÓN DE OBRAS, BIENES Y SERVICIOS";
        $pdf = \PDF::loadView('pdf.uaci.requisicion',compact('requisicionobra','tipo'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('requisicionobra.pdf');
    }
}
