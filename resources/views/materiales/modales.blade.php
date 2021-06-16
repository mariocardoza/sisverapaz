
<div class="modal fade" id="modal_registrar" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Agregar Material</h4>
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
        <center>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <button id="btnguardar" type="button" class="btn btn-success">Guardar</button></center>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-sm">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar</h4>
      </div>
      <div class="modal-body">
      	<form id="form_edit">
      		<div class="row">
              <div class="col-md-12">
                @include('materiales.formulario')
              </div>
          </div>
      	</form>
      </div>
      <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button id="btneditar" type="button" class="btn btn-success">Guardar</button></center>
      </div>
    </div>
  </div>
</div>