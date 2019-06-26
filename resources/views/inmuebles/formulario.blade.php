<div class="form-group{{ $errors->has('numero_catastral') ? ' has-error' : '' }}">
    <label for="numero_catastral" class="col-md-4 control-label">Número catastral</label>

    <div class="col-md-6">
        {{ Form::text('numero_catastral', null,['class' => 'form-control','data-inputmask' => '"mask": "99999999-9999-99"','data-mask']) }}

        @if ($errors->has('numero_catastral'))
            <span class="help-block">
                <strong>{{ $errors->first('numero_catastral') }}</strong>
            </span>
         @endif
    </div>
</div>

<div class="form-group{{ $errors->has('contribuyente_id') ? ' has-error' : '' }}">
    <label for="" class="col-md-4 control-label">Contribuyente</label>

    <div class="col-md-6">
        {{ Form::select('contribuyente_id', $contribuyentes,null,['class' => 'form-control chosen-select']) }}

        @if ($errors->has('contribuyente_id'))
            <span class="help-block">
                <strong>{{ $errors->first('contribuyente_id') }}</strong>
            </span>
         @endif
    </div>
    <div class="col-md-2">
        <button class="btn btn-default" type="button" id="" data-toggle="modal" data-target="#btncontribuyente">Agregar nuevo</button>
    </div>
</div>

<div class="form-group{{ $errors->has('direccion_inmueble') ? ' has-error' : '' }}">
    <label for="direccion_inmueble" class="col-md-4 control-label">Dirección del Inmueble</label>

    <div class="col-md-6">
        {{ Form::textarea('direccion_inmueble', null,['class' => 'form-control', 'rows' => 3]) }}

        @if ($errors->has('direccion_inmueble'))
            <span class="help-block">
                <strong>{{ $errors->first('direccion_inmueble') }}</strong>
            </span>
         @endif
    </div>
</div>

<div class="form-group{{ $errors->has('medida_inmueble') ? ' has-error' : '' }}">
    <label for="medida_inmueble" class="col-md-4 control-label">Medida del inmueble</label>

    <div class="col-md-6">
            {{ Form::text('medida_inmueble', null,['class' => 'form-control']) }}
        @if ($errors->has('medida_inmueble'))
            <span class="help-block">
                <strong>{{ $errors->first('medida_inmueble') }}</strong>
            </span>
         @endif
    </div>
</div>

<div class="form-group{{ $errors->has('numero_escritura') ? ' has-error' : '' }}">
    <label for="numero_escritura" class="col-md-4 control-label">Número de escritura</label>

    <div class="col-md-6">
        {{ Form::text('numero_escritura', null,['class' => 'form-control','data-inputmask' => '"mask": "99999999-9999-99"','data-mask']) }}

        @if ($errors->has('numero_escritura'))
            <span class="help-block">
                <strong>{{ $errors->first('numero_escritura') }}</strong>
            </span>
         @endif
    </div>
</div>

<div class="form-group{{ $errors->has('metros_acera') ? ' has-error' : '' }}">
    <label for="metros_acera" class="col-md-4 control-label">Metros de acera</label>

    <div class="col-md-6">
        {{ Form::text('metros_acera', null,['class' => 'form-control']) }}

        @if ($errors->has('metros_acera'))
            <span class="help-block">
                <strong>{{ $errors->first('metros_acera') }}</strong>
            </span>
         @endif
    </div>
</div>      

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="btncontribuyente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de Contribuyente
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    @include('contribuyentes.formulario')
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarcontribuyente" data-dismiss="modal" class="btn btn-success">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>