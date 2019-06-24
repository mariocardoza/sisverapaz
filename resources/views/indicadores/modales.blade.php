<div class="modal fade" tabindex="-1" id="modal_indicador" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar indicador</h4>
      </div>
      <div class="modal-body">
      	<form id="losdatos" action="" class="form-horizontal">
      		<div class="row">
	          	<div class="col-md-12">
		          	<div class="form-group">
		                <label class="control-label col-md-4">Nombre del indicador (*)</label>
		                <div class="col-md-6">
		                    <input type="text" required id="nombre_indicador" class="form-control" placeholder="Nombre del indicador">
		                </div>       
		            </div>
					
					<div class="form-group">
		                <label class="control-label col-md-4">Descripción (*)</label>
		                <div class="col-md-6">
		                    <input type="text" required id="descripcion_indicador" class="form-control" placeholder="Digite la descripción del indicador">
		                </div>       
		            </div>

		            <div class="form-group">
		                <label class="control-label col-md-4">Porcentaje (*)</label>
		                <div class="col-md-6">
		                    <input type="number" required id="porcentaje_indicador" min="1" max="100" step="1" class="form-control" placeholder="Digite el porcentaje que aplica">
		                </div>       
		            </div>
	          	</div>
	        </div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="agregar_indicador" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_indicador_e" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Editar indicador</h4>
      </div>
      <div class="modal-body">
        <form id="losdatos_e" action="" class="form-horizontal">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nombre del indicador (*)</label>
                        <div class="col-md-6">
                            <input type="text" required id="nombre_indicador_e" class="form-control" placeholder="Nombre del indicador">
                            <input type="hidden" required id="elcodigo_e" class="form-control" placeholder="Nombre del indicador">
                        </div>       
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4">Descripción (*)</label>
                        <div class="col-md-6">
                            <input type="text" required id="descripcion_indicador_e" class="form-control" placeholder="Digite la descripción del indicador">
                        </div>       
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Porcentaje (*)</label>
                        <div class="col-md-6">
                            <input type="number" required id="porcentaje_indicador_e" min="1" max="100" step="1" class="form-control" placeholder="Digite el porcentaje que aplica">
                        </div>       
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="agregar_indicador_e" class="btn btn-primary">Editar</button>
      </div>
    </div>
  </div>
</div>