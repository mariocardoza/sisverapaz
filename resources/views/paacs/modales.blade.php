<!-- Modal -->
<?php
use Carbon\Carbon;
$date = Carbon::now();
$date = $date->format('Y');
?>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_crear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Registrar nuevo plan</h4>
            </div>
            <div class="modal-body">
              {{ Form::open(['class' => '','id' => 'form_paac']) }}
              
              <input type="hidden" name="total" id="total" value="0.00" readonly>
              <div class="form-group">
                <label for="" class="control-label">Descripcion plan anual</label>
                  <div class="">
                      <select name="descripcion" id="" class="chosen-select-width">
                          <option value="Fodes 20% Gasto Corriente">Fodes 20% Gasto Corriente</option>
                          <option value="Fodes 80% Gasto Corriente">Fodes 80% Gasto Corriente</option>
                          <option value="Financiación propia">Financiación propia</option>
                      </select>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="control-label">
                      Año
                  </label>
                  <div>
                        <input type="number" name="anio" class="form-control" value="<?= $date; ?>" >
                  </div>
              </div>
              {{Form::close()}}
            </div>
            <div class="modal-footer">
              <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" id="registrar_paac" class="btn btn-success">Agregar</button></center>
            </div>
          </div>
          </div>
        </div>