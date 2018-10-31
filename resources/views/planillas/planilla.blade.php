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
      <th>Total descuentos</th>
      <th>Salario liquido</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($empleados as $empleado)
      <tr>
        <td>
          <input value="{{$empleado->id}}" type="hidden" name='empleado_id[]' class="form-control"/>
          {{$empleado->nombre}}
        </td>
        <td><input type="text" name='salario[]' readonly value="{{$empleado->salario}}" class="form-control"/></td>
        @foreach ($retenciones as $r)
          <td><input type="text" name='{{$r->nombre}}[]' readonly value="{{number_format(App\Retencion::valor($r->id,$empleado->salario),2)}}" class="form-control"/></td>
        @endforeach
        <td><input type="text" name='renta[]' readonly value="{{number_format(App\Renta::renta($empleado->pago,$empleado->salario),2)}}" class="form-control"/></td>
      </tr>
    @endforeach
  </tbody>
</table>
