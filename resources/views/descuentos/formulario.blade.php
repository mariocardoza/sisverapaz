@php
	$tipos=App\CategoriaDescuento::where('estado',1)->get();
	$emples=App\Empleado::where('estado',1)->get();
    $categorias=[];
    $empleados=[];
    foreach ($tipos as $t ) {
        $categorias[$t->id]=$t->nombre;
    }
    foreach ($emples as $t ) {
        $empleados[$t->id]=$t->nombre;
    }
@endphp
<div class="form-group">
	<label for="nombre" class="col-md-4 control-label">Nombre del empleado</label>

	<div class="col-md-6">
		@if (!isset($empleado))
			{!!Form::select('empleado_id',
			$empleados
			,null, ['class'=>'chosen-select-width','placeholder'=>'Seleccione un empleado'])!!}
		@else
			{!!Form::select('empleado_id',
			[$empleado->id=>$empleado->nombre]
			,null, ['class'=>'form-control'])!!}
		@endif
	</div>
</div>

<div class="form-group">
	<label for="numero_de_cuenta" class="col-md-4 control-label">Tipo de descuento</label>

	<div class="col-md-6">
		{{ Form::select('categoriadescuento_id',$categorias, null, ['class' => 'chosen-select-width','placeholder'=>'Seleccione un tipo de préstamo']) }}
	</div>
</div>

<div class="form-group{{$errors->has('cuota') ? 'has-error' : '' }}">
	<label for="cuenta" class="col-md-4 control-label">Cuota a pagar</label>

	<div class="col-md-6">
		{{ Form::number('cuota', null, ['class' => 'form-control']) }}
	</div>
</div>

<div class="form-group{{$errors->has('fecha_inicio') ? 'has-error' : '' }}">
	<label for="cuenta" class="col-md-4 control-label">Inicio</label>

	<div class="col-md-6">
		{{ Form::date('fecha_inicio', null, ['class' => 'form-control']) }}
	</div>
</div>

<div class="form-group{{$errors->has('fecha_fin') ? 'has-error' : '' }}">
	<label for="cuenta" class="col-md-4 control-label">Fin</label>

	<div class="col-md-6">
		{{ Form::date('fecha_fin', null, ['class' => 'form-control']) }}
	</div>
</div>
