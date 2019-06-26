<div class="form-group{{ $errors->has('empleado_id') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Empleado</label>

@php
  $empleados=App\Detalleplanilla::empleados();
@endphp
    <div class="col-md-6">
      @if (isset($detalle))
        {!!Form::select('empleado_id',
          [$detalle->empleado->id=>$detalle->empleado->nombre]
          ,null, ['class'=>'form-control','readonly'=>'readonly'])!!}
      @else
        {!!Form::select('empleado_id',
          $empleados
          ,null, ['class'=>'form-control'])!!}
      @endif
    </div>
</div>

<div class="form-group{{ $errors->has('salario') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Salario</label>
    <div class="col-md-6">
      {!!Form::number('salario',null,['class'=>'form-control'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('tipo_pago') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Forma de pago</label>
    <div class="col-md-6">
      {!!Form::select('tipo_pago',
          ['1'=>'Planilla']
          ,null, ['class'=>'form-control'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('pago') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Tiempo de pago</label>
    <div class="col-md-6">
      {!!Form::select('pago',
          ['1'=>'Mensual','2'=>'Quincenal']
          ,null, ['class'=>'form-control'])!!}
    </div>
</div>
