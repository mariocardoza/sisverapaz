<div class="form-group{{ $errors->has('item') ? 'has-error' : '' }}">
	<label for="item" class="col-md-4 control-label">Item</label>
	<div class="col-md-2">
		{!! Form::text('item', null,['class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group{{ $errors->has('nombre_categoria') ? 'has-error' : '' }}">
	<label for="nombre_categoria" class="col-md-4 control-label">Nombre categoría</label>
	<div class="col-md-4">
		{!! Form::text('nombre_categoria', null,['class' => 'form-control']) !!}
	</div>
</div>