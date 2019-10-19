
<div class="modal fade" tabindex="-1" id="md_material" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar materiales</h4>
      </div>
      <div class="modal-body">
        <form id="form_material" class="form-horizontal">
          <div class="row">
              <div class="col-md-12">
                @include('materiales.formulario')
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_material" class="btn btn-primary">Registrar</button></center>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="md_categoria" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar categoría</h4>
      </div>
      <div class="modal-body">
      	<form id="form_categoria" class="form-horizontal">
      		<div class="row">
	          	<div class="col-md-12">
		            <div class="form-group">
		                <label class="control-label col-md-4">Nombre</label>
		                <div class="col-md-6">
                        {{Form::hidden('item',1,['class'=>'form-control','placeholder'=>'Digite un ítem','required'])}}
		                    {{ Form::text('nombre_categoria', null,['placeholder'=>'Digite el nombre de la categoriría','class' => 'form-control','autocomplete'=>'off','required']) }}
		                </div>       
		            </div>
	          	</div>
	        </div>
      	</form>
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_categoria" class="btn btn-primary">Registrar</button></center>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="md_medida" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar unidad de medida</h4>
      </div>
      <div class="modal-body">
        <form id="form_medida" class="form-horizontal">
          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-4">Nombre de la unidad</label>
                    <div class="col-md-6">
                      
                        {{Form::text('nombre_medida',null,['class'=>'form-control','placeholder'=>'Digite un nombre','required'])}}
                    </div>       
                </div>
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_medida" class="btn btn-primary">Registrar</button></center>
      </div>
    </div>
  </div>
</div>