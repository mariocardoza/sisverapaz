<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecretariaController extends Controller
{
    public function planillas($id){
        $proveedores = \App\Proveedor::where('estado',1)->get();
    	$tipo = "REPORTE DE PROVEEDORES";
    	$pdf = \PDF::loadView('pdf.uaci.proveedor',compact('proveedores','tipo'));
    	$pdf->setPaper('letter', 'landscape');
    	return $pdf->stream('proveedores.pdf');
    }
}
