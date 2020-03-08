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
            Fecha de generación: <b>{{$dato[2]."/".$dato[1]."/".$dato[0]}}</b>
      </p>
    @php
      for($i=0;$i<10;$i++){
          $columna[$i]=0;
      }
    @endphp
    <table class="table table-hover" width="100%">
      <thead>
        <tr>
            <th>Empleado</th>
            <th>Salario base</th>
            <th>ISSS Empleado</th>
            <th>AFP Empleado</th>
            <th>Renta</th>
            <th>Crédito</th>
            <th>Otros descuentos</th>
            <th>Total descuentos</th>
            <th>Salario líquido</th>
            <th>Firma</th>
        </tr>  
      </thead>
      <tbody>
            @foreach($planillas as $planilla)
            @php
                $p=$d=0;
            @endphp
            <tr>
            <td>{{$planilla->empleado->nombre}}</td>
                <td>${{$planilla->empleado->detalleplanilla->salario}}</td>
            <td>${{$planilla->issse}}</td>
                <td>${{$planilla->afpe}}</td>
                <td>${{$planilla->renta}}</td>
                <td>
                    @if($planilla->prestamos!="")
                    @php
                        $p=$planilla->prestamos;
                        $columna[7]+=$p;
                    @endphp
                    ${{$p}}
                    @else
                    --
                    @endif
                </td>
                <td>
                    @if($planilla->descuentos!='')
                        @php
                            $d=$planilla->descuentos;
                            $columna[8]+=$d;
                        @endphp
                         ${{$d}}
                         @else
                         --
                    @endif
                </td>
            <td>$
                @php
                    $total=$planilla->issse+$planilla->afpe+$planilla->renta+$p+$d;
                @endphp
                {{number_format($total,2)}}</td>
                @php
                    $resta=$planilla->empleado->detalleplanilla->salario-$total;
                @endphp
            <td>${{number_format($resta,2)}}</td>
            <td>

            </td>
            </tr>
            @php
                $columna[0]+=$planilla->empleado->detalleplanilla->salario;
                $columna[1]+=$planilla->issse;
                $columna[3]+=$planilla->afpe;
                $columna[6]+=$planilla->renta;
                $columna[8]+=$total;
                $columna[9]+=$resta;
            @endphp
            @endforeach
            
        </tbody>
    </table>
  </div>
@endsection