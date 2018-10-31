<table class="table table-striped table-bordered table-hover" >
  <thead>
    <tr>
      <th>Empleado</th>
      <th>Salario base</th>
      <th>ISSS</th>
      <th>AFP</th>
      <th>INSAFORP</th>
      <th>Crédito</th>
      <th>Total descuentos</th>
      <th>Salario liquido</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($empleados as $empleado)
      <tr>
        <td>
          <input value="{{$empleado->empleado->id}}" type="hidden" name='empleado_id[]' class="form-control"/>
          {{$empleado->empleado->nombre}}
        </td>
        <td><input type="text" name='salario[]' readonly value="{{$empleado->salario}}" class="form-control"/></td>
        <?php
        $isss=($retencion->isss/100)*$empleado->salario;
        $afp=($retencion->afp/100)*$empleado->salario;
        $insaforp=($retencion->insaforp/100)*$empleado->salario;

        $monto=\App\Prestamo::prestamo($empleado->empleado->id);
        ?>
        <td><input type="text" name='isss[]' readonly value="{{number_format(($retencion->isss/100)*$empleado->salario,2)}}" class="form-control"/></td>
        <td><input type="text" name='afp[]' readonly value="{{number_format(($retencion->afp/100)*$empleado->salario,2)}}" class="form-control"/></td>
        <td><input type="text" name='insaforp[]' readonly value="{{number_format(($retencion->insaforp/100)*$empleado->salario,2)}}" class="form-control"/></td>
        <td><input type="text" name='prestamo[]' value="{{$monto}}" class="form-control"/></td>
        <td><input type="text" name='desc[]' readonly value="{{number_format($isss+$afp+$insaforp,2)}}" class="form-control"/></td>
        <td><input type="text" name='total[]' readonly value="{{number_format($empleado->salario-($isss+$afp+$insaforp),2)}}" class="form-control"/></td>
      </tr>
    @endforeach
  </tbody>
</table>
