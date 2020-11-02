<style>
  #inmuebles_espacio button{
    margin: 10px 10px;
    width: 80%;
  }
</style>
{{-- Modal para inmuebles --}}
<div class="modal fade" tabindex="-1" id="modal_mis_inmuebles" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="inmueble_label"></h4>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center" id="inmuebles_espacio">
                    </div>
              </div>
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></center>
        </div>
      </div>
    </div>
  </div>
{{-- Modal para facturas pendientes --}}
  <div class="modal fade" tabindex="-1" id="modal_mis_facturas" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="factura_label"></h4>
        </div>
        <div class="modal-body">
                <div class="row">
                  <div class="row">
                    <div class="col-md-12">
                  <div class="togglebutton" style="margin: 20px">
                    <label>
                      <input type="checkbox" id="todos_c" onclick="todos()">
                      <span class="toggle"></span>
                      Todos
                    </label>
                  </div>
                  </div>
                </div>
                    <div class="col-md-12 text-center" id="facturas_espacio">
                    </div>
              </div>
        </div>
        <div class="modal-footer">
          <center>
            <button type="button" class="btn btn-success" data-dismiss="modal" id="generar_facturas" onclick="verFacturas()">Generar facturas</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </center>
        </div>
      </div>
    </div>
  </div>