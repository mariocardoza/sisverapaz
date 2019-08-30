<div class="form-group{{ $errors->has('codigo') ? ' has-error' : '' }}">
  <label for="" class="col-md-4 control-label">Codigo</label>
    <div class="col-md-6">
        {!!Form::text('codigo',null,['class' => 'form-control', 'id' => 'codigo' ])!!}

        @if ($errors->has('codigo'))
        <span class="help-block">
            <strong>{{ $errors->first('codigo') }}</strong>
        </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('cantidad') ? ' has-error' :''}}">
  <label for="" class="col-md-4 control-label">Cantidad</label>
    <div class="col-md-6">
      {!!Form::text('cantidad',null,['class' => 'form-control', 'id' => 'cantidad' ])!!}
      @if ($errors->has('cantidad'))
      <span class="help-block">
          <strong>{{ $errors->first('cantidad') }}</strong>
      </span>
      @endif
    </div>
</div>

<div class="form-group{{ $errors->has('unidad_medida') ? ' has-error' : ''}}">
  <label for="" class="col-md-4 control-label">Unidad de medida</label>
    <div class="col-md-6">
      {!!Form::text('unidad_medida',null,['class' => 'form-control', 'id' => 'unidad' ])!!}
      @if ($errors->has('unidad_medida'))
      <span class="help-block">
          <strong>{{ $errors->first('unidad_medida') }}</strong>
      </span>
      @endif
    </div>
</div>

<div class="form-group{{ $errors->has('descripcion') ? ' has-error' : ''}}">
  <label for="" class="col-md-4 control-label">Descripcion</label>
    <div class="col-md-6">
      {!!Form::text('descripcion',null,['class' => 'form-control', 'id' => 'descripcion' ])!!}
      @if($errors->has('descripcion'))
        <span class="help-block">
          <strong>{{ $errors->first('descripcion') }}</strong>
        </span>
      @endif
    </div>
</div>
