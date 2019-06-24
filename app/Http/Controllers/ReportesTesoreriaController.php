<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesTesoreriaController extends Controller
{
    public function pagos($id)
    {
    	$pagos = \App\Pago::findorFile($id);
    	$tipo = "REPORTE DE PAGO DE IMPUESTOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.pago',compact('pagos','tipo'));
    	$pdf->setPaper('letter','portrait');
    	return $pdf->stream('pagos.pdf');
	}
	public function planillas($id){
        $datoplanilla=\App\Datoplanilla::find($id);
        $planillas=\App\Planilla::where('datoplanilla_id',$id)->get();
    	$tipo = "PLANILLA DE EMPLEADOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.planilla',compact('datoplanilla','planillas','tipo'));
    	$pdf->setPaper('letter', 'landscape');
    	return $pdf->stream('planilla.pdf');
    }
}
