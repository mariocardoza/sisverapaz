<div class="form-group{{ $errors->has('categoria') ? ' has-error' : '' }}">
	<label for="categoria" class="col-md-4 control-label">Categoría</label>
	<div class="col-md-6">
		{{ Form::text('categoria', null,['id'=>'nom_categoria','class' => 'form-control']) }}
	</div>
</div>