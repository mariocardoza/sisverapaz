<table class="table table-striped table-bordered table-hover" >
  <thead>
    @php
        $t_salario=0;
        $t_renta=0;
        $t_prestamo=0;
        $t_deduccion=0;
        $t_disponible=0;
    @endphp
    <tr>
      <th>Empleado</th>
      <th>Salario base</th>
      @foreach ($retenciones as $key=>$r)
        <th>{{$r->nombreCompleto($r->nombre)}}</th>
        @php
            $columna[$key]=0;
        @endphp
      @endforeach
      <th>Renta</th>
      <th>Crédito</th>
      <th>Total deducciones</th>
      <th>Salario líquido</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($empleados as $empleado)
    @if ($empleado->pago==$i+1)
      <tr>
        <td>
          <input value="{{$empleado->id}}" type="hidden" name='empleado_id[]' class="form-control"/>
          {{$empleado->nombre}}
        </td>
        <td>
            <input type="hidden" name='salario[]' value="{{$empleado->salario}}">
            ${{number_format($empleado->salario,2)}}
            @php
                $t_salario+=$empleado->salario;
            @endphp
          </td>
          @php
              $sum_retenciones=0;
          @endphp
        @foreach ($retenciones as $key=>$r)
          <td>
            @php
              $retencion=App\Retencion::valor($r->id,$empleado->salario);
              if($r->tipo==0){
              $sum_retenciones+=$retencion;
              }
            @endphp
            <input type="hidden" name='{{$r->nombre}}[]' value="{{number_format($retencion,2)}}">
            ${{number_format($retencion,2)}}
          </td>
          @php
            $columna[$key]+=number_format($retencion,2)
          @endphp
        @endforeach
        <td>
          @php
          $nogravado=$empleado->salario-$sum_retenciones;
          $renta=App\Renta::renta($empleado->pago,$nogravado);
            $sum_retenciones+=$renta;
          @endphp
            <input type="hidden" name='renta[]' value="{{number_format($renta,2)}}">
            @if ($renta==0)
            ---
          @else
          ${{number_format($renta,2)}}
          @php
              $t_renta+=$renta;
          @endphp
          @endif
          </td>
        <td>
          @php
          $prestamo=App\Prestamo::comprobarPrestamo($empleado->id);
          $valor_p=($prestamo==null) ?0:$prestamo->cuota;
          $sum_retenciones+=$valor_p;
          $t_prestamo+=$valor_p;
          @endphp
          @if ($prestamo==null)
          <input type="hidden" name='prestamos[]' value="0">
            ---
          @else
          <input type="hidden" name='prestamos[]' value="{{$prestamo->id}}">
          ${{number_format($valor_p,2)}}
          @endif
        </td>
        <td>${{number_format($sum_retenciones,2)}}</td>
        <td>${{number_format($empleado->salario-$sum_retenciones,2)}}</td>
        @php
            $t_deduccion+=$sum_retenciones;
            $t_disponible+=$empleado->salario-$sum_retenciones;
        @endphp
      </tr>
    @endif
    @endforeach
    <tr>
      <td>
        <b>
          Totales
        </b>
      </td>
    <td>${{number_format($t_salario,2)}}</td>
      @foreach ($retenciones as $key=>$r)
      <td>${{$columna[$key]}}</td>
      @endforeach
      <td>${{number_format($t_renta,2)}}</td>
      <td>${{number_format($t_prestamo,2)}}</td>
      <td>${{number_format($t_deduccion,2)}}</td>
      <td>${{number_format($t_disponible,2)}}</td>
    </tr>
  </tbody>
</table>
