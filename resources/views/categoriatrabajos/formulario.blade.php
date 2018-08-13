 <div class="form-group{{ $errors->has('nombre_categoria') ? 'has-error' : ''}}">
 	<label for="nombre_categoria" class="col-md-4 control-label">Categoría de trabajo</label>
 	<div class="col-md-4">
 		{!!Form::text('nombre_categoria',null,['class' => 'form-control'])!!}
 	</div>
 </div>