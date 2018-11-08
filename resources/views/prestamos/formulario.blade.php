<div class="form-group{{$errors->has('empleado_id') ? 'has-error' : '' }}">
	<label for="num_factura" class="col-md-4 control-label">Nombre del empleado</label>

	<div class="col-md-6">
    <select name="empleado_id" class="form-control">
	@if (!isset($prestamo))
		@foreach ($empleados as $empleado)
		<option value="{{$empleado->id}}">{{empleado_prestamo($empleado->id)}}</option>
		@endforeach
	@else
	<option value="{{$prestamo->empleado->id}}">{{$prestamo->empleado->nombre}}</option>
	@endif
    </select>
		@if ($errors->has('empleado_id'))
		<span class="help-block">
			<strong>{{ $errors->first('empleado_id') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{$errors->has('banco') ? 'has-error' : '' }}">
	<label for="banco" class="col-md-4 control-label">Nombre del banco</label>

	<div class="col-md-6">
		{{ Form::text('banco', null, ['class' => 'form-control']) }}

		@if ($errors->has('banco'))
		<span class="help-block">
			<strong>{{ $errors->first('banco') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{$errors->has('numero_de_cuenta') ? 'has-error' : '' }}">
	<label for="numero_de_cuenta" class="col-md-4 control-label">Número de cuenta</label>

	<div class="col-md-6">
		{{ Form::text('numero_de_cuenta', null, ['class' => 'form-control']) }}

		@if ($errors->has('banco'))
		<span class="help-block">
			<strong>{{ $errors->first('numero_de_cuenta') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{$errors->has('monto') ? 'has-error' : '' }}">
	<label for="monto" class="col-md-4 control-label">Monto del prestamo</label>

	<div class="col-md-6">
		{{ Form::text('monto', null, ['class' => 'form-control']) }}

		@if ($errors->has('banco'))
		<span class="help-block">
			<strong>{{ $errors->first('monto') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{$errors->has('numero_de_cuotas') ? 'has-error' : '' }}">
	<label for="cuenta" class="col-md-4 control-label">Número de cuotas</label>

	<div class="col-md-6">
		{{ Form::number('numero_de_cuotas', null, ['class' => 'form-control']) }}

		@if ($errors->has('banco'))
		<span class="help-block">
			<strong>{{ $errors->first('numero_de_cuotas') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{$errors->has('cuota') ? 'has-error' : '' }}">
	<label for="cuenta" class="col-md-4 control-label">Cuota a pagar</label>

	<div class="col-md-6">
		{{ Form::number('cuota', null, ['class' => 'form-control']) }}

		@if ($errors->has('banco'))
		<span class="help-block">
			<strong>{{ $errors->first('cuota') }}</strong>
		</span>
		@endif
	</div>
</div>
