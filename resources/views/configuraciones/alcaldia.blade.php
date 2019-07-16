<div class="row">
  <div class="form-group">
    <label for="" class="control-label col-md-2">Dirección</label>
    <div class="col-md-9">
      {{Form::textarea("direccion_alcaldia",null,['class'=>'form-control','rows'=>2])}}
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">NIT</label>
    <div class="col-md-9">
      {{Form::text("nit_alcaldia",null,['class'=>'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask'])}}
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">Teléfono</label>
    <div class="col-md-9">
      {{Form::text("telefono_alcaldia",null,['class'=>'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask'])}}
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">Fax</label>
    <div class="col-md-9">
      {{Form::text("fax_alcaldia",null,['class'=>'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask'])}}
    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label col-md-2">Correo electrónico</label>
    <div class="col-md-9">
      {{Form::text("email_alcaldia",null,['class'=>'form-control'])}}
    </div>
  </div>

</div>
