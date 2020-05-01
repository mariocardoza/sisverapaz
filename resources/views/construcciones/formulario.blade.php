@php
	$contribuyentes=\App\Contribuyente::where('estado',1)->with('inmueble')->get();
	
@endphp
<div class="form-group{{ $errors->has('contribuyente_id') ? ' has-error' : '' }}">
	<label for="" class="control-label">Contribuyente</label>
	<div class="row">
		<div class="col-md-10">
			<select name="contribuyente_id" id="elcontribuyente" class="chosen-select-width">
				<option value="">Seleccione contribuyente</option>
				@foreach($contribuyentes as $contribuyente)
				<option value="{{$contribuyente->id}}">{{$contribuyente->nombre}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-2">
			<button class="btn btn-primary" id="nuevo_contri" type="button"><i class="fa fa-plus"></i></button>
		</div>
	</div>
</div>

<div class="form-group{{ $errors->has('contribuyente_id') ? ' has-error' : '' }}">
	<label for="" class="control-label">Inmueble</label>
	<div class="row">
		<div class="col-md-10">
			<select name="inmueble_id" id="elinmueble" class="chosen-select-width">
				<option value="">Seleccione el inmueble</option>
				
			</select>
		</div>
		<div class="col-md-2">
			<button class="btn btn-primary" id="nuevo_inmueble" type="button"><i class="fa fa-plus"></i></button>
		</div>
	</div>
</div>

<div class="form-group{{$errors->has('direccion_construccion') ? 'has-error' : '' }}">
	<label for="direccion_construccion" class="control-label">Dirección </label>

	<div class="">
		{{ Form::textarea('direccion_construccion', null, ['class' => 'form-control','rows'=>2]) }}
	</div>
</div>

<div class="form-group{{$errors->has('presupuesto') ? 'has-error' : '' }}">
	<label for="presupuesto" class="control-label">Presupuesto </label>

	<div class="">
		{{ Form:: number('presupuesto', null, ['value'=>0,'class' => 'form-control','min'=>0,'steps'=>0.01]) }}
	</div>
</div>

<div class="form-group{{$errors->has('detalle') ? 'has-error' : '' }}">
	<label for="detalle" class="control-label">Detalle de la construccion (opcional) </label>

	<div class="">
		{{ Form::textarea('detalle', null, ['class' => 'form-control','rows'=>2]) }}
	</div>
</div>


