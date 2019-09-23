<div class="modal fade" tabindex="-1" id="modal_fecha" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Registrar pago de vacaciones</h4>
        </div>
        <div class="modal-body">
            <form id="form_vacacion" action="" class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-md-4">Fecha de pago</label>
                          <div class="col-md-6">
                              <input type="hidden" name="id_vacacion" id="id_vacacion">
                              {{ Form::date('fecha_pago', null,['id'=>'fecha_pago','class' => 'form-control','autocomplete'=>'off','required']) }}
                          </div>       
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-4">Inicia vacaciones</label>
                          <div class="col-md-6">
                              {{ Form::date('fecha_vacacion', null,['id'=>'fecha_vacacion','class' => 'form-control','autocomplete'=>'off','required']) }}
                          </div>       
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-4">Pago correspodiente</label>
                          <div class="col-md-6">
                              {{ Form::text('pago', null,['id'=>'pago','class' => 'form-control','autocomplete'=>'off','readonly'=>'readonly']) }}
                          </div>       
                      </div>
                    </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="registrar_vacacion" class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </div>
  </div>