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
    	$tipo = "PLANILLA DE EMPLEADOS";
    	$pdf = \PDF::loadView('pdf.tesoreria.planilla',compact('datoplanilla','planillas','tipo'));
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
	
	public function boleta($id)
	{
		$planilla=\App\planilla::find($id);
		$html = '<h1>HTML Example</h1>
			Some special characters: &lt; € &euro; &#8364; &amp; è &egrave; &copy; &gt; \\slash \\\\double-slash \\\\\\triple-slash
			<h2>List</h2>
			List example:
			<ol>
				<li><b>bold text</b></li>
				<li><i>italic text</i></li>
				<li><u>underlined text</u></li>
				<li><b>b<i>bi<u>biu</u>bi</i>b</b></li>
				<li><a href="http://www.tecnick.com" dir="ltr">link to http://www.tecnick.com</a></li>
				<li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.<br />Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</li>
				<li>SUBLIST
					<ol>
						<li>row one
							<ul>
								<li>sublist</li>
							</ul>
						</li>
						<li>row two</li>
					</ol>
				</li>
				<li><b>T</b>E<i>S</i><u>T</u> <del>line through</del></li>
				<li><font size="+3">font + 3</font></li>
				<li><small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal</li>
			</ol>
			<dl>
				<dt>Coffee</dt>
				<dd>Black hot drink</dd>
				<dt>Milk</dt>
				<dd>White cold drink</dd>
			</dl>';
        $pdf = new TCPDF();
        $pdf::SetTitle('Hello World');
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('hello_world.pdf');
	}
}
