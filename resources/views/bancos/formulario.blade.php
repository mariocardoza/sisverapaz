<div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Nombre</label>

    <div class="col-md-6">
        {{ Form::text('nombre', null,['id'=>'nom_banco','class' => 'form-control']) }}
    </div>
</div>