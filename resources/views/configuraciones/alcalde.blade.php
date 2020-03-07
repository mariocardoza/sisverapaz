<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="" class="control-label">Nombre</label>
      <div class="">
        {{Form::text("nombre_alcalde",null,['class'=>'form-control'])}}
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">DUI</label>
      <div class="">
        {{Form::text("dui_alcalde",null,['class'=>'form-control','data-inputmask' => '"mask": "99999999-9"','data-mask'])}}
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">NIT</label>
      <div class="">
        {{Form::text("nit_alcalde",null,['class'=>'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask'])}}
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">Fecha de nacimiento</label>
      <div class="">
          @if($configuraciones!='')
            @if($configuraciones->nacimiento_alcalde != '')
          {{Form::text("nacimiento_alcalde",$configuraciones->nacimiento_alcalde->format('d-m-Y'),['class'=>'nacimiento form-control'])}}
          @else
          {{Form::text("nacimiento_alcalde",null,['class'=>'nacimiento form-control'])}}
          @endif
        @else
          {{Form::text("nacimiento_alcalde",null,['class'=>'nacimiento form-control'])}}
        @endif
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">Oficio</label>
      <div class="">
        {{Form::text("oficio_alcalde",null,['class'=>'form-control'])}}
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label for="" class="control-label">Dirección</label>
      <div class="">
        {{Form::textarea("domicilio_alcalde",null,['class'=>'form-control','rows'=>2])}}
      </div>
    </div>
  </div>

  

</div>
