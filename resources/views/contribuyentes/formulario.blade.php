<div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Nombre completo</label>

    <div class="col-md-6">
        {{ Form::text('nombre', null,['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
    <label for="dui" class="col-md-4 control-label">Número de DUI</label>

    <div class="col-md-6">
        {{ Form::text('dui', null,['class' => 'form-control','data-inputmask' => '"mask": "99999999-9"','data-mask']) }}
    </div>
</div>

<div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
    <label for="nit" class="col-md-4 control-label">Número de NIT</label>

    <div class="col-md-6">
        {{ Form::text('nit', null,['class' => 'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask']) }}
    </div>
</div>

<div class="form-group{{ $errors->has('nacimiento') ? ' has-error' : '' }}">
    <label for="nacimiento" class="col-md-4 control-label">Fecha de Nacimiento</label>

    <div class="col-md-6">
        <?php
        use Carbon\Carbon;
        $date = Carbon::now();
        $mayor = $date->subYears(18);
        $max = $mayor->format('Y-m-d');
        ?>
        @if(isset($contribuyente))
            {{ Form::date('nacimiento', $contribuyente->nacimiento->format('Y-m-d'),['class' => 'form-control','max' => $max]) }}
        @else
            {{ Form::date('nacimiento', null,['class' => 'form-control','max' => $max]) }}
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
    <label for="direccion" class="col-md-4 control-label">Dirección</label>

    <div class="col-md-6">
        {{ Form::textarea('direccion', null,['class' => 'form-control','rows' => 3]) }}
    </div>
</div>

<div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
    <label for="sexo" class="col-md-4 control-label">Sexo</label>

    <div class="col-md-6">
        Másculino
        {{ Form::radio('sexo', 'Másculino',false) }}
        Femenino
        {{ Form::radio('sexo', 'Femenino',false) }}
    </div>
</div>



<div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
    <label for="telefono" class="col-md-4 control-label">Teléfono</label>

    <div class="col-md-6">
        {{ Form::text('telefono', null,['class' => 'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask']) }}
    </div>
</div>
