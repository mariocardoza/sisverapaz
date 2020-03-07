<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="" class="control-label">Dirección</label>
      <div class="">
        {{Form::textarea("direccion_alcaldia",null,['class'=>'form-control','rows'=>2])}}
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">NIT</label>
      <div class="">
        {{Form::text("nit_alcaldia",null,['class'=>'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask'])}}
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">Correo electrónico</label>
      <div class="">
        {{Form::text("email_alcaldia",null,['class'=>'form-control'])}}
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">Teléfono</label>
      <div class="">
        {{Form::text("telefono_alcaldia",null,['class'=>'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask'])}}
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="" class="control-label">Fax</label>
      <div class="">
        {{Form::text("fax_alcaldia",null,['class'=>'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask'])}}
      </div>
    </div>
  </div>
  

  

 

  

</div>
