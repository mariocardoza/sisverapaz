@extends('pdf.plantilla')

@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
@section('reporte')
<div id="content">
	<br>
	

	<br>
	<table class="table table-bordered table-striped" >
		<thead>
			<tr>
				<th>N°</th>
                <th>Nombre</th>
                <th>Cargo</th>
				<th>Salario neto</th>
				<th>Renta</th>
				<th>Salario líquido</th>
				<th>Firma</th>
			</tr>
		</thead>
		<tbody>
            @php
                $tneto=$trenta=$tliquido=0;
            @endphp
            @foreach($catorcena->proyectoplanilla as $index => $i)
            @php
                $renta=$neto=$liquido=0.00;
                $neto=$i->salario_dia*$i->numero_dias;
                $renta=$neto*0.1;
                $liquido=$neto-$renta;
                $tneto+=$neto;
                $trenta+=$renta;
                $tliquido+=$liquido;
            @endphp
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$i->empleado->nombre}}</td>
                <td>{{$i->cargo->nombre}}</td>
                <td class="text-right">${{number_format($neto,2)}}</td>
                <td class="text-right">${{number_format($renta,2)}}</td>
                <td class="text-right">${{number_format($liquido,2)}}</td>
                <td></td>
            </tr>
            @endforeach
		</tbody>
		<tfoot>
            <tr>
                <th colspan="3">Totales</th>
                <th class="text-right">${{number_format($tneto,2)}}</th>
                <th class="text-right">${{number_format($trenta,2)}}</th>
                <th class="text-right">${{number_format($tliquido,2)}}</th>
            </tr>
        </tfoot>
	</table>
</div>
@endsection