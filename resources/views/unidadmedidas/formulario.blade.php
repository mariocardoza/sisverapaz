<div class="form-group{{$errors->has('nombre_medida') ? 'has-error' : '' }}">
	<label for="nombre_medida" class="col-md-4 control-label">Unidad de medida</label>

	<div class="col-md-6">
		{{ Form::text('nombre_medida', null, ['class' => 'form-control','autocomplete'=>'off']) }}
		@if ($errors->has('nombre_medida'))
		<span class="help-block">
			<strong>{{ $errors->first('nombre_medida') }}</strong>
		</span>
		@endif
	</div>
</div>