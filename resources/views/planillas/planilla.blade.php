<table class="table table-striped table-bordered table-hover" >
  <thead>
    @php
      Use Carbon\Carbon;
        $ahorita=now();
        $t_salario=0;
        $t_renta=0;
        $t_prestamo=0;
        $t_descuento=0;
        $t_deduccion=0;
        $t_disponible=0;
        
    @endphp
    <tr>
      <th>Empleado</th>
      <th>Cargo</th>
      <th>Salario base</th>
      @foreach ($retenciones as $key=>$r)
        <th>{{$r->nombreCompleto($r->nombre)}}</th>
        @php
            $columna[$key]=0;
        @endphp
      @endforeach
      <th>Renta</th>
      <th>Créditos</th>
      <th>Otros descuentos</th>
      <th>Total deducciones</th>
      <th>Salario líquido</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($empleados as $empleado)
    @if ($empleado->pago==$i+1)
    @if($empleado->fecha_inicio<$ahorita)
      <tr>
        <td>
          <input value="{{$empleado->id}}" type="hidden" name='empleado_id[]' class="form-control"/>
          {{$empleado->nombre}}
        </td>
        <td>{{$empleado->ncargo}}</td>
        <td>
         @php
            $salario=$salario_dia=0.0;
            $hoy=Carbon::now();
            $inicio=Carbon::createFromFormat('Y-m-d',$empleado->fecha_inicio);
            $dias=$inicio->diffInDays($hoy);
            
            if($dias>30){
              $salario=$empleado->salario;
            }else{
              $salario_dia=$empleado->salario/30;
              $salario=$salario_dia*$dias;
            }
           
         @endphp
            <input type="hidden" name='salario[]' value="{{$salario}}">
            ${{number_format($salario,2)}}
            @php
                $t_salario+=$salario;
            @endphp
            
          </td>
          @php
              $sum_retenciones=0;
          @endphp
        @foreach ($retenciones as $key=>$r)
          <td>
            @php
              $retencion=App\Retencion::valor($r->id,$salario);
              
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
          $nogravado=$salario-$sum_retenciones;
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
          $prestamos=App\Prestamo::comprobarPrestamo($empleado->id);
         

          /*foreach($prestamos as $pp){
            $valor_p+=($prestamo==null) ?0:$prestamo->cuota;
          }*/
          
          $sum_retenciones+=$prestamos;
          $t_prestamo+=$prestamos;
          @endphp
          @if ($prestamos==0)
          <input type="hidden" name='prestamos[]' value="0">
            ---
          @else
          <input type="hidden" name='prestamos[]' value="{{$prestamos}}">
          ${{number_format($prestamos,2)}}
          @endif
        </td>
        <td>
          @php
              $descuentos=App\Descuento::comprobardescuento($empleado->id);
              
              $sum_retenciones+=$descuentos;
              $t_descuento+=$descuentos;
          @endphp
          @if ($descuentos==0)
          <input type="hidden" name='descuentos[]' value="0">
            ---
          @else
          <input type="hidden" name='descuentos[]' value="{{$descuentos}}">
          ${{number_format($descuentos,2)}}
          @endif
        </td>
        <td>${{number_format($sum_retenciones,2)}}</td>
        <td>${{number_format($salario-$sum_retenciones,2)}}</td>
        @php
            $t_deduccion+=$sum_retenciones;
            $t_disponible+=$salario-$sum_retenciones;
            
        @endphp
      </tr>
    @endif
    @endif
    @endforeach
    <tr>
      <td colspan="2">
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
      <td>${{number_format($t_descuento,2)}}</td>
      <td>${{number_format($t_deduccion,2)}}</td>
      <td>${{number_format($t_disponible,2)}}</td>
    </tr>
  </tbody>
</table>
