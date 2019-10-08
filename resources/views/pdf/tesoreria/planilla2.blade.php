@extends('pdf.plantilla')
@section('reporte')
@include('pdf.tesoreria.cabecera')
@include('pdf.tesoreria.pie')
  <div id="content">
      <p>
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
            {{App\Datoplanilla::obtenerMes($dato[1])}}
            </b>
            <br>
        @endif
            Fecha de generación: <b>{{$dato[2]."-".$dato[1]."-".$dato[0]}}</b>
      </p>
    @php
      for($i=0;$i<10;$i++){
          $columna[$i]=0;
      }
    @endphp
    <table class="table table-hover table-bordered" width="100%" >
      <thead>
        <tr>
            <th>Empleado</th>
            <th>Salario base</th>
            <th>ISSS</th>
            <th>AFP</th>
            <th>Renta</th>
            <th>Crédito</th>
            <th>Total deducciones</th>
            <th>Salario líquido</th>
            <th>Firma</th>
        </tr>  
      </thead>
      <tbody>
            @foreach($planillas as $planilla)
            @php
                $p=0;
            @endphp
            <tr>
            <td>{{$planilla->empleado->nombre}}</td>
                <td>${{number_format($planilla->empleado->detalleplanilla->salario,2)}}</td>
            <td>${{number_format($planilla->issse,2)}}</td>
                <td>${{number_format($planilla->afpe,2)}}</td>
                <td>${{number_format($planilla->renta,2)}}</td>
                <td>
                    @if($planilla->prestamo_id!="")
                    @php
                        $p=$planilla->prestamo->cuota;
                        $columna[7]+=$p;
                    @endphp
                    ${{$p}}
                    @else
                    --
                    @endif
                </td>
            <td>$
                @php
                    $total=$planilla->issse+$planilla->afpe+$planilla->renta+$p;
                @endphp
                {{number_format($total,2)}}</td>
                @php
                    $resta=$planilla->empleado->detalleplanilla->salario-$total;
                @endphp
            <td>${{number_format($resta,2)}}</td>
            <td></td>
            </tr>
            @php
                $columna[0]+=$planilla->empleado->detalleplanilla->salario;
                $columna[1]+=$planilla->issse;
                $columna[2]+=$planilla->afpe;
                $columna[3]+=$planilla->renta;
                $columna[4]+=$total;
                $columna[5]+=$resta;
            @endphp
            @endforeach
           
        </tbody>
    </table>
  </div>
@endsection