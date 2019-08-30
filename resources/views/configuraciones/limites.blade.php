<div class="row">
    <div class="form-group">
        <label for="" class="control-label col-md-4">Libre gestión por adjudicación</label>
        <div class="col-md-8">
        {{Form::number("libre_gestion",null,['class'=>'form-control','min'=>0.00,'steps'=>0.00])}}
        </div>
    </div>
    <div class="form-group">
        <label for="" class="control-label col-md-4">Libre gestión licitación pública</label>
        <div class="col-md-8">
        {{Form::number("licitacion",null,['class'=>'form-control'])}}
        </div>
    </div>
</div>