<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesTesoreriaController extends Controller
{
    public function pagos($id)
    {
    	$pagos = \App\Pago::findorFail($id);
    	$tipo = "REPORTE DE PAGO DE IMPUESTOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.pago',compact('pagos','tipo'));
    	$pdf->setPaper('letter','portrait');
    	return $pdf->stream('pagos.pdf');
	}

	public function reciboc($id)
	{
		$construccion = \App\Construccion::findorFail($id);
    	$tipo = "REPORTE DE PAGO DE IMPUESTOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.reciboc',compact('construccion','tipo'));
    	$pdf->setPaper('letter','landscape');
    	return $pdf->stream('Recibo.pdf');	
	}

	public function recibop($id)
	{
		$perpetuidad = \App\Perpetuidad::findorFail($id);
    	$tipo = "REPORTE DE PAGO DE IMPUESTOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.recibop',compact('perpetuidad','tipo'));
    	$pdf->setPaper('letter','landscape');
    	return $pdf->stream('Recibo.pdf');	
	}

    public function pagorentas($id)
    {
    	$configuracion = \App\Configuracion::first();
        $pagorentas = \App\PagoRenta::findorFail($id);
        $tipo = "REPORTE PAGO DE IMPUESTO/RENTA";
        $pdf = \PDF::loadView('pdf.tesoreria.pagorenta',compact('configuracion','pagorentas','tipo'));
        $pdf->setPaper('letter','portrait');
        return $pdf->stream('pagorentas.pdf');
    }

	public function planillas($id){
        $datoplanilla=\App\Datoplanilla::find($id);
		$planillas=\App\Planilla::where('datoplanilla_id',$id)->get();
		$configuracion=\App\Configuracion::find(1);
    	$tipo = "PLANILLA DE EMPLEADOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.planilla',compact('datoplanilla','planillas','tipo','configuracion'));
    	$pdf->setPaper('letter', 'landscape');
    	return $pdf->stream('planilla.pdf');
	}
	
	public function planillas2($id){
        $datoplanilla=\App\Datoplanilla::find($id);
        $planillas=\App\Planilla::where('datoplanilla_id',$id)->get();
    	$tipo = "PLANILLA DE EMPLEADOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.planilla2',compact('datoplanilla','planillas','tipo'));
    	$pdf->setPaper('letter', 'landscape');
    	return $pdf->stream('planilla.pdf');
	}
	
	public function planillaaprobada($id){
		$configuracion=\App\Configuracion::first();
        $datoplanilla=\App\Datoplanilla::find($id);
        $planillas=\App\Planilla::where('datoplanilla_id',$id)->get();
    	$tipo = "PLANILLA DE EMPLEADOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.planillaaprobada',compact('datoplanilla','planillas','tipo','configuracion'));
    	$pdf->setPaper('letter', 'landscape');
    	return $pdf->stream('planilla.pdf');
	}
	
	public function boletageneral($id)
	{
		$configuracion=\App\Configuracion::first();
        $datoplanilla=\App\Datoplanilla::find($id);
        $planillas=\App\Planilla::where('datoplanilla_id',$id)->get();
    	//$tipo = "PLANILLA DE EMPLEADOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.boletageneral',compact('datoplanilla','planillas','configuracion'));
		$pdf->setPaper('letter', 'portrait');
		//return view('pdf.tesoreria.boletageneral',compact('datoplanilla','planillas','configuracion'));
    	return $pdf->stream('boleta.pdf');
		
	}
}
