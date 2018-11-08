<table class="table table-striped table-bordered table-hover" >
  <thead>
    <tr>
      <th>Empleado</th>
      <th>Salario base</th>
      @foreach ($retenciones as $r)
        <th>{{$r->nombre}}</th>
      @endforeach
      <th>Renta</th>
      <th>Crédito</th>
      <th>Total deducciones</th>
      <th>Salario liquido</th>
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
            {{number_format($empleado->salario,2)}}
          </td>
          @php
              $sum_retenciones=0;
          @endphp
        @foreach ($retenciones as $r)
          <td>
            @php
              $retencion=App\Retencion::valor($r->id,$empleado->salario);
              $sum_retenciones+=$retencion;
            @endphp
            <input type="hidden" name='{{$r->nombre}}[]' value="{{number_format($retencion,2)}}">
            {{number_format($retencion,2)}}
          </td>
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
          {{number_format($renta,2)}}
          @endif
          </td>
        <td>
          @php
          $prestamo=App\Prestamo::comprobarPrestamo($empleado->id);
          $sum_retenciones+=$prestamo;
          @endphp
          @if ($prestamo==0)
            ---
          @else
          {{number_format($prestamo,2)}}
          @endif
        </td>
        <td>{{number_format($sum_retenciones,2)}}</td>
        <td>{{number_format($empleado->salario-$sum_retenciones,2)}}</td>
      </tr>
    @endif
    @endforeach
  </tbody>
</table>
