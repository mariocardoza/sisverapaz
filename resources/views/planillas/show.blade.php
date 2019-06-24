@extends('layouts.app')

@section('migasdepan')
<h1>
	Planillas
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/planillas') }}"><i class="fa fa-dashboard"></i>Control de planillas</a></li>
	<li class="active">Planillas</li> </ol>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10" >
            Planilla: <b>
                @if($datoplanilla->tipo_pago==1)
                Mensual
                @else
                Quincenal
                @endif
            </b>
            @php
            $dato= explode("-",$datoplanilla->fecha);
        @endphp
        <br>
        Fecha de generación: <b>{{$dato[2]."-".$dato[1]."-".$dato[0]}}</b>
            <table class="table table-striped table-bordered table-hover" >
                <thead>
                    <th>Empleado</th>
                    <th>Salario base</th>
                    <th>ISSS Empleado</th>
                    <th>ISSS Patronal</th>
                    <th>AFP Empleado</th>
                    <th>AFP Patronal</th>
                    <th>INSAFORP Patronal</th>
                    <th>Renta</th>
                    <th>Crédito</th>
                    <th>Total deducciones</th>
                    <th>Salario líquido</th>
                </thead>
                <tbody>
                    @foreach($planillas as $planilla)
                    @php
                        $p=0;
                    @endphp
                    <tr>
                    <td>{{$planilla->empleado->nombre}}</td>
                        <td>{{$planilla->empleado->detalleplanilla[0]->salario}}</td>
                    <td>{{$planilla->issse}}</td>
                        <td>{{$planilla->isssp}}</td>
                        <td>{{$planilla->afpe}}</td>
                        <td>{{$planilla->afpp}}</td>
                        <td>{{$planilla->insaforpp}}</td>
                        <td>{{$planilla->renta}}</td>
                        <td>
                            @if($planilla->prestamo_id!="")
                            @php
                                $p=$planilla->prestamo->cuota;
                            @endphp
                            {{$p}}
                            @else
                            --
                            @endif
                        </td>
                    <td>
                        @php
                            $total=$planilla->issse+$planilla->afpe+$planilla->renta+$p;
                        @endphp
                        {{number_format($total,2)}}</td>
                    <td>{{number_format($planilla->empleado->detalleplanilla[0]->salario-$total,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
		</div>
	</div>
</div>
@endsection