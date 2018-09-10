<div class="row">
  <div class="form-group">
    <label for="" class="control-label col-md-2">Nombre</label>
    <div class="col-md-9">
      {{Form::text("nombre_alcalde",null,['class'=>'form-control'])}}
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">Fecha de nacimiento</label>
    <div class="col-md-9">
      @if(isset($configuraciones))
        {{Form::text("nacimiento_alcalde",$configuraciones->nacimiento_alcalde->format('d-m-Y'),['class'=>'nacimiento form-control'])}}
      @else
        {{Form::text("nacimiento_alcalde",null,['class'=>'nacimiento form-control'])}}
      @endif
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">DUI</label>
    <div class="col-md-9">
      {{Form::text("dui_alcalde",null,['class'=>'form-control','data-inputmask' => '"mask": "99999999-9"','data-mask'])}}
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">NIT</label>
    <div class="col-md-9">
      {{Form::text("nit_alcalde",null,['class'=>'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask'])}}
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">Dirección</label>
    <div class="col-md-9">
      {{Form::textarea("domicilio_alcalde",null,['class'=>'form-control','rows'=>2])}}
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">Oficio</label>
    <div class="col-md-9">
      {{Form::text("oficio_alcalde",null,['class'=>'form-control'])}}
    </div>
  </div>

</div>
