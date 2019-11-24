<div class="form-group{{ $errors->has('contribuyente_id') ? ' has-error' : '' }}">
	<label for="" class="col-md-4 control-label">Contribuyente</label>
	<div class="col-md-6">
		<select name="contribuyente_id" id="contribuyente" class="form-control">
			<option value="">Seleccione</option>
			@foreach ($contribuyentes as $item)
			<option value="{{$item->id}}">{{$item->nombre}}</option>
			@endforeach
		</select>
		@if ($errors->has('contribuyente_id'))
		<span class="help-block">
			<strong>{{ $errors->first('contribuyente_id') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{$errors->has('tipopago_id') ? 'has-error' : '' }}">
		<label for="tipopago_id" class="col-md-4 control-label">Tipo de pagos</label>
	
		<div class="col-md-6">
			{{ Form::text('tipopago_id', null, ['class' => 'form-control']) }}
			@if ($errors->has('tipopago_id'))
			<span class="help-block">
				<strong>{{ $errors->first('y') }}</strong>
			</span>
			@endif
		</div>
	</div>


<div class="form-group{{$errors->has('monto') ? 'has-error' : '' }}">
	<label for="monto" class="col-md-4 control-label">Monto a pagar</label>

	<div class="col-md-6">
		{{ Form::text('monto', null, ['class' => 'form-control']) }}
		@if ($errors->has('monto'))
		<span class="help-block">
			<strong>{{ $errors->first('monto') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="form-group{{$errors->has('num_factura') ? 'has-error' : '' }}">
	<label for="num_factura" class="col-md-4 control-label">Número de factura</label>

	<div class="col-md-6">
		{{ Form::text('num_factura', null, ['class' => 'form-control']) }}

		@if ($errors->has('num_factura'))
		<span class="help-block">
			<strong>{{ $errors->first('num_factura') }}</strong>
		</span>
		@endif
	</div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="formcargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de Cargo
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    @include('cargos.formulario')
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarcargo" data-dismiss="modal" class="btn btn-success">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>