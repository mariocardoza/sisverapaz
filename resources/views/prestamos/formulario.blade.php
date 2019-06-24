<div class="form-group">
	<label for="nombre" class="col-md-4 control-label">Nombre del empleado</label>

	<div class="col-md-6">
		@if (!isset($prestamo))
			{!!Form::select('empleado_id',
			$empleados
			,null, ['class'=>'chosen-select-width','placeholder'=>'Seleccione un empleado'])!!}
		@else
			{!!Form::select('empleado_id',
			[$prestamo->empleado->id=>$prestamo->empleado->nombre]
			,null, ['class'=>'form-control'])!!}
		@endif
	</div>
</div>
@php
	$bancos=App\Banco::bancos();
@endphp
<div class="form-group">
	<label for="banco" class="col-md-4 control-label">Banco</label>

	<div class="col-md-6">
		{!!Form::select('banco_id',
          $bancos
          ,null, ['class'=>'chosen-select-width','placeholder'=>'Seleccione un banco'])!!}
	</div>
</div>

<div class="form-group">
	<label for="numero_de_cuenta" class="col-md-4 control-label">Número de cuenta</label>

	<div class="col-md-6">
		{{ Form::text('numero_de_cuenta', null, ['class' => 'form-control']) }}
	</div>
</div>

<div class="form-group">
	<label for="monto" class="col-md-4 control-label">Monto del préstamo</label>

	<div class="col-md-6">
		{{ Form::number('monto', null, ['class' => 'form-control']) }}
	</div>
</div>

<div class="form-group{{$errors->has('numero_de_cuotas') ? 'has-error' : '' }}">
	<label for="cuotas" class="col-md-4 control-label">Número de cuotas</label>

	<div class="col-md-6">
		{{ Form::number('numero_de_cuotas', null, ['class' => 'form-control']) }}
	</div>
</div>

<div class="form-group{{$errors->has('cuota') ? 'has-error' : '' }}">
	<label for="cuenta" class="col-md-4 control-label">Cuota a pagar</label>

	<div class="col-md-6">
		{{ Form::number('cuota', null, ['class' => 'form-control']) }}
	</div>
</div>
