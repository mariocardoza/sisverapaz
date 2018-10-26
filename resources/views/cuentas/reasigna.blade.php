<div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Nombre de la cuenta</label>

    <div class="col-md-6">
        {{ Form::text('nombre', null,['id'=>'nomb_cuenta','class' => 'form-control']) }}
        @if ($errors->has('nombre'))
        <span class="help-block">
            <strong>{{ $errors->first('nombre') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('monto_inicial') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Monto inicial</label>

    <div class="col-md-6">
        {{ Form::double('monto_inicial', null,['class' => 'form-control']) }}

        @if ($errors->has('monto_inicial'))
            <span class="help-block">
                <strong>{{ $errors->first('monto_inicial') }}</strong>
            </span>
         @endif
    </div>
</div>

<div class="form-group{{ $errors->has('motivo_reasignacion') ? ' has-error' : '' }}">
    <label for="motivo_reasignacion" class="col-md-4 control-label">Motivo de reasignación</label>

    <div class="col-md-6">
        {{ Form::text('motivo_reasignacion', null,['id'=>'reasigna','class' => 'form-control']) }}
        @if ($errors->has('motivo_reasignacion'))
        <span class="help-block">
            <strong>{{ $errors->first('motivo_reasignacion') }}</strong>
        </span>
        @endif
    </div>
</div>