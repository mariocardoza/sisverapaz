<div class="form-group{{ $errors->has('empleado_id') ? ' has-error' : '' }}">
	<label for="" class="col-md-4 control-label">Empleado</label>
	<div class="col-md-4">
		<select name="empleado_id" id="empleado" class="form-control">
			<option value="">Seleccione</option>
			@foreach($empleados as $empleado)
			<option value="{{$empleado->id}}">{{$empleado->nombre}}</option>
			@endforeach
		</select>
		@if ($errors->has('empleado_id'))
		<span class="help-block">
			<strong>{{ $errors->first('empleado_id') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('categoriatrabajo_id') ? ' has-error' : '' }}">
	<label for="" class="col-md-4 control-label">Categoría</label>
	<div class="col-md-4">
		<select name="categoriatrabajo_id" id="categoriatrabajo" class="form-control">
			<option value="">Seleccione</option>
			@foreach($categoriatrabajos as $categoriatrabajo)
			<option value="{{$categoriatrabajo->id}}">{{$categoriatrabajo->nombre_categoria}}</option>
			@endforeach
		</select>
		@if ($errors->has('categoriatrabajo_id'))
		<span class="help-block">
			<strong>{{ $errors->first('categoriatrabajo_id') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('cargo_id') ? ' has-error' : '' }}">
	<label for="" class="col-md-4 control-label">Cargo</label>
	<div class="col-md-4">
		<select name="cargo_id" id="cargo" class="form-control">
			<option value="">Seleccione</option>
			@foreach($cargos as $cargo)
			<option value="{{$cargo->id}}">{{$cargo->cargo}}</option>
			@endforeach
		</select>
		@if ($errors->has('cargo_id'))
		<span class="help-block">
			<strong>{{ $errors->first('cargo_id') }}</strong>
		</span>
		@endif
	</div>
</div>