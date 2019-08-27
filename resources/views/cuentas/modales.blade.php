<div class="modal fade" tabindex="-1" id="modal_registrar_cuenta" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="gridSystemModalLabel">Registrar cuenta</h4>
            </div>
            <div class="modal-body">
                <form id="form_cuenta" action="" class="">
                    @include('cuentas.formulario')
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" id="registrar_cuenta" class="btn btn-primary">Registrar</button>
            </div>
          </div>
        </div>
      </div>