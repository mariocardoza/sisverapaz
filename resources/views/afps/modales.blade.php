<div class="modal fade" tabindex="-1" id="modal_afp" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar AFP</h4>
      </div>
      <div class="modal-body">
      	<form id="afp" action="" class="">
      		<div class="row">
	          	<div class="col-md-12">
		            <div class="form-group">
		                <label class="control-label">Nombre</label>
		                <div class="">
		                    {{ Form::text('nombre', null,['id'=>'nombre','class' => 'form-control','autocomplete'=>'off','required']) }}
		                </div>       
		            </div>
	          	</div>
	        </div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_afp" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>