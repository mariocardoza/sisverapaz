<div class="form-group">
  <label for="" class="col-md-4 control-label">Actividad</label>
  <div class="col-md-6">
    {!! Form::textarea('actividad',null,['id'=>'actividad','class' => 'form-control','placeholder'=>'Digite la actividad a realizar','rows'=>3]) !!}
  </div>
</div>

<div class="form-group">
  <label for="" class="col-md-4 control-label">Unidad Solicitante</label>
  <div class="col-md-6">
    {{Form::select('unidad_id',$unidades,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione la unidad','id'=>'unidad_id'])}}
  </div>
</div>

  <div class="form-group">
    <label for="" class="col-md-4 control-label">Responsable</label>
      <div class="col-md-6">
        {{Form::hidden('',Auth()->user()->id,['id'=>'user_id'])}}
        {!!Form::text('',Auth()->user()->empleado->nombre,['class' => 'form-control','readonly'])!!}
      </div>
  </div>

  <div class="form-group">
    <label for="" class="col-md-4 control-label">Fecha actividad</label>
    <div class="col-md-6">
      {{Form::text('fecha_actividad',null,['class'=>'form-control unafecha','autocomplete'=>'off','id'=>'fecha_actividad'])}}
  

    </div>
  </div>

  <div class="form-group">
    <label for="" class="col-md-4 control-label">Observaciones</label>
      <div class="col-md-6">
        {!!Form::textarea('observaciones',null,['id'=>'observaciones','class' => 'form-control','rows' => 3])!!}
      </div>
  </div>
