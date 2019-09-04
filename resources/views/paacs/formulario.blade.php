<div class="form-group">
  <label for="" class="col-md-2 control-label">Obra, Bien o Servicio</label>
  <div class="col-md-8">
    {{ Form::textarea('obra', null,['class' => 'form-control','rows' => 3,'id' => 'obra']) }}
  </div>
</div>
<br /><br />
<div class="form-group">
  <div class="col-md-12">
    <label for="" class="col-md-4 control-label"
      ><b>Montos establecidos por cada mes</b></label
    >
  </div>
</div>

<div class="form-group">
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Enero</label>
    {{ Form::number('enero', null,['class' => 'form-control ','id' => 'ene','steps' => 0.00,'min' => 0]) }}
  </div>
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Febrero</label>
    {{ Form::number('febrero', null,['class' => 'form-control ','id' => 'feb','steps' => 0.00,'min' => 0]) }}
  </div>
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Marzo</label>
    {{ Form::number('marzo', null,['class' => 'form-control ','id' => 'mar','steps' => 0.00,'min' => 0]) }}
  </div>

  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Abril</label>
    {{ Form::number('abril', null,['class' => 'form-control ','id' => 'abr','steps' => 0.00,'min' => 0]) }}
  </div>
</div>

<div class="form-group">
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Mayo</label>
    {{ Form::number('mayo', null,['class' => 'form-control ','id' => 'may','steps' => 0.00,'min' => 0]) }}
  </div>
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Junio</label>
    {{ Form::number('junio', null,['class' => 'form-control ','id' => 'jun','steps' => 0.00,'min' => 0]) }}
  </div>
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Julio</label>
    {{ Form::number('julio', null,['class' => 'form-control','id' => 'jul','steps' => 0.00,'min' => 0]) }}
  </div>
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Agosto</label>
    {{ Form::number('agosto', null,['class' => 'form-control','id' => 'ago','steps' => 0.00,'min' => 0]) }}
  </div>
</div>

<div class="form-group">
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Septiembre</label>
    {{ Form::number('septiembre', null,['class' => 'form-control','id' => 'sep','steps' => 0.00,'min' => 0]) }}
  </div>
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Octubre</label>
    {{ Form::number('octubre', null,['class' => 'form-control','id' => 'oct','steps' => 0.00,'min' => 0]) }}
  </div>
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Noviembre</label>
    {{ Form::number('noviembre', null,['class' => 'form-control','id' => 'nov','steps' => 0.00,'min' => 0]) }}
  </div>
  <div class="col-md-3">
    <label for="" class="col-md-2 control-label">Diciembre</label>
    {{ Form::number('diciembre', null,['class' => 'form-control','id' => 'dic','steps' => 0.00,'min' => 0]) }}
  </div>
</div>

<br />
