


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
	/	<span class="help-block">
			<strong>{{ $errors->first('cargo_id') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="ver info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">Información categoría
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="panel-body">
					@include('empleados.formulario')
				</div>
				<div class="panel-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="button" id="guardarempleado" data-dismiss="modal" class="btn btn-success">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>