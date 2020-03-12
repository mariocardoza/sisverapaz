@extends('layouts.app')

@section('migasdepan')
<h1>
	Planillas
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
	<li><a href="{{ url('/planillas') }}"><i class="fa fa-dashboard"></i>Planillas</a></li>
	<li class="active">Detalle </li> </ol>
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
        @php
            for($i=0;$i<=10;$i++){
                $columna[$i]=0;
            }
        @endphp
        @if($datoplanilla->tipo_pago==1)
            <b>
            Del 01 al 
            @php
                setlocale(LC_TIME, 'spanish');
                $fecha = $dato[2]."-".$dato[1]."-".$dato[0];
                $timestamp = strtotime( $fecha );
                $diasdelmes = date( "t", $timestamp );
                echo $diasdelmes;
            @endphp
            de 
            {{App\Datoplanilla::obtenerMes($datoplanilla->mes)}}
            </b>
            <br>
        @endif
        Fecha de generación: <b>{{$dato[2]."-".$dato[1]."-".$dato[0]}}</b>
            <table class="table table-striped table-bordered table-hover" >
                <thead>
                    <th>Empleado</th>
                    <th>Cargo</th>
                    <th>Salario base</th>
                    <th>ISSS Empleado</th>
                    <th>ISSS Patronal</th>
                    <th>AFP Empleado</th>
                    <th>AFP Patronal</th>
                    <th>INSAFORP Patronal</th>
                    <th>Renta</th>
                    <th>Crédito</th>
                    <th>Otros descuentos</th>
                    <th>Total deducciones</th>
                    <th>Salario líquido</th>
                    @if($datoplanilla->estado>=3)
                    <th></th>
                    @endif
                </thead>
                <tbody>
                    @foreach($planillas as $planilla)
                    @php
                        $p=$d=0;
                    @endphp
                    <tr>
                        <td>{{$planilla->empleado->nombre}}</td>
                        <td>{{$planilla->empleado->detalleplanilla->cargo->cargo}}</td>
                        <td class="text-right">${{number_format($planilla->empleado->detalleplanilla->salario,2)}}</td>
                        <td class="text-right">${{number_format($planilla->issse,2)}}</td>
                        <td class="text-right">${{number_format($planilla->isssp,2)}}</td>
                        <td class="text-right">${{number_format($planilla->afpe,2)}}</td>
                        <td class="text-right">${{number_format($planilla->afpp,2)}}</td>
                        <td class="text-right">${{number_format($planilla->insaforpp,2)}}</td>
                        <td class="text-right">${{number_format($planilla->renta,2)}}</td>
                        <td class="text-right">
                        @if($planilla->prestamos!="")
                            @php
                                $p=$planilla->prestamos;
                                $columna[7]+=$p;
                            @endphp
                            ${{number_format($p,2)}}
                        @else
                            --
                        @endif
                        </td>
                        <td class="text-right">
                            @if($planilla->descuentos!='')
                            @php
                                $d=$planilla->descuentos;
                                $columna[8]+=$d;
                            @endphp
                            ${{number_format($d,2)}}
                            @else
                            --
                            @endif
                        </td>
                        <td class="text-right">$
                            @php
                                $total=$planilla->issse+$planilla->afpe+$planilla->renta+$p+$d;
                            @endphp
                            {{number_format($total,2)}}
                        </td>
                        @php
                            $resta=$planilla->empleado->detalleplanilla->salario-$total;
                        @endphp
                        <td class="text-right">${{number_format($resta,2)}}</td>
                    
                    @if($datoplanilla->estado>=3)
                    <td>
                        <a target="_blank" href="{{ url('reportestesoreria/boleta/'.$planilla->id)}}" class="btn btn-success"><i class="fa fa-print"></i></a>
                    </td>
                    @endif
                    </tr>
                    @php
                        $columna[0]+=$planilla->empleado->detalleplanilla->salario;
                        $columna[1]+=$planilla->issse;
                        $columna[2]+=$planilla->isssp;
                        $columna[3]+=$planilla->afpe;
                        $columna[4]+=$planilla->afpp;
                        $columna[5]+=$planilla->insaforpp;
                        $columna[6]+=$planilla->renta;
                        $columna[9]+=$total;
                        $columna[10]+=$resta;
                    @endphp
                    @endforeach
                    <tr>
                        <td colspan="2"><b>Totales</b></td>
                        @for($i=0;$i<=10;$i++)
                    <td class="text-right">${{number_format($columna[$i],2)}}</td>
                        @endfor
                        <td></td>
                    </tr>
                </tbody>
            </table>
		</div>
	</div>
</div>
@endsection