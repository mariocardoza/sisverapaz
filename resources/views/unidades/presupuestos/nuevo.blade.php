@php
    $medidas=[];
    $medidas=App\UnidadMedida::get();
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="" class="control-label">Material</label>
            <div class="" id="aqui_select">
            </div>
          </div>
    </div>
    <div class="col-md-6">
      <label for="" class="control-label">Unidad de medida</label>
      <select name="unidad_medida" id="" class="chosen-select-width">
        <option value="">Seleccione..</option>
        @foreach ($medidas as $m)
            <option value="{{$m->id}}">{{$m->nombre_medida}}</option>
        @endforeach
      </select>
    </div>
</div>
  <br />
  <div class="form-group">
    <div class="col-md-12">
      <label for="" class="col-md-4 control-label"
        ><b>Cantidades requeridas por cada mes</b></label
      >
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Enero</label>
      {{ Form::number('enero', 0,['class' => 'form-control ','id' => 'ene','steps' => 0.00,'min' => 0]) }}
    </div>
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Febrero</label>
      {{ Form::number('febrero', 0,['class' => 'form-control ','id' => 'feb','steps' => 0.00,'min' => 0]) }}
    </div>
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Marzo</label>
      {{ Form::number('marzo', 0,['class' => 'form-control ','id' => 'mar','steps' => 0.00,'min' => 0]) }}
    </div>
  
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Abril</label>
      {{ Form::number('abril', 0,['class' => 'form-control ','id' => 'abr','steps' => 0.00,'min' => 0]) }}
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Mayo</label>
      {{ Form::number('mayo', 0,['class' => 'form-control ','id' => 'may','steps' => 0.00,'min' => 0]) }}
    </div>
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Junio</label>
      {{ Form::number('junio', 0,['class' => 'form-control ','id' => 'jun','steps' => 0.00,'min' => 0]) }}
    </div>
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Julio</label>
      {{ Form::number('julio', 0,['class' => 'form-control','id' => 'jul','steps' => 0.00,'min' => 0]) }}
    </div>
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Agosto</label>
      {{ Form::number('agosto', 0,['class' => 'form-control','id' => 'ago','steps' => 0.00,'min' => 0]) }}
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Septiembre</label>
      {{ Form::number('septiembre', 0,['class' => 'form-control','id' => 'sep','steps' => 0.00,'min' => 0]) }}
    </div>
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Octubre</label>
      {{ Form::number('octubre', 0,['class' => 'form-control','id' => 'oct','steps' => 0.00,'min' => 0]) }}
    </div>
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Noviembre</label>
      {{ Form::number('noviembre', 0,['class' => 'form-control','id' => 'nov','steps' => 0.00,'min' => 0]) }}
    </div>
    <div class="col-md-3">
      <label for="" class="col-md-2 control-label">Diciembre</label>
      {{ Form::number('diciembre', 0,['class' => 'form-control','id' => 'dic','steps' => 0.00,'min' => 0]) }}
    </div>
  </div>
  
  <br />
  <br />
  