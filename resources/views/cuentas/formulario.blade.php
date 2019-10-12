@php
    $losbancos=\App\Banco::where('estado',1)->get();
    $bancos=[];
    foreach($losbancos as $banco){
        $bancos[$banco->id]=$banco->nombre;
    }
@endphp
<div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
    <label for="nombre" class="control-label">Nombre de la cuenta</label>
    <div class="">
        {{ Form::text('nombre', null,['id'=>'num_cuenta','class' => 'form-control','autocomplete'=>'off']) }}
        @if ($errors->has('nombre'))
        <span class="help-block">
            <strong>{{ $errors->first('nombre') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
    <label for="descripcion" class="control-label">Descripción de la cuenta</label>
    <div class="">
        {{ Form::textarea('descripcion', null,['id'=>'descripcion','class' => 'form-control','rows'=>2,'autocomplete'=>'off']) }}
        @if ($errors->has('descripcion'))
        <span class="help-block">
            <strong>{{ $errors->first('descripcion') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('numero_cuenta') ? ' has-error' : '' }}">
    <label for="numero_cuenta" class="control-label">Número de Cuenta</label>
    <div class="">
        {{ Form::number('numero_cuenta', null,['id'=>'num_cuenta','class' => 'form-control','step'=>'1']) }}
        @if ($errors->has('numero_cuenta'))
        <span class="help-block">
            <strong>{{ $errors->first('numero_cuenta') }}</strong>
        </span>
        @endif
    </div>
</div>



<div class="form-group{{ $errors->has('banco_id') ? ' has-error' : '' }}">
    <label for="banco" class="control-label">Banco</label>

    <div class="">
        {{ Form::select('banco_id',$bancos, null,['id'=>'nomb_banco','class' => 'chosen-select-width','placeholder'=>'Seleccione un banco']) }}
        @if ($errors->has('banco'))
        <span class="help-block">
            <strong>{{ $errors->first('banco') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('monto_inicial') ? ' has-error' : '' }}">
    <label for="nombre" class="control-label">Monto inicial</label>

    <div class="">
        {{ Form::number('monto_inicial', null,['class' => 'form-control','min'=>0,'steps'=>'0.01']) }}

        @if ($errors->has('monto_inicial'))
            <span class="help-block">
                <strong>{{ $errors->first('monto_inicial') }}</strong>
            </span>
         @endif
    </div>
</div>

<div class="form-group{{ $errors->has('fecha_de_apertura') ? ' has-error' : '' }}">
        <label for="fecha_de_apertura" class="control-label">Fecha de apertura</label>
    
        <div class="">
            {{ Form::text('fecha_de_apertura', null,['class' => 'form-control unafecha','autocomplete'=>'off']) }}
    
            @if ($errors->has('fecha_de_apertura'))
                <span class="help-block">
                    <strong>{{ $errors->first('fecha_de_apertura') }}</strong>
                </span>
             @endif
        </div>
    </div>
