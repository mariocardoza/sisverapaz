<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_detalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Necesidad de la requisicion</h4>
    </div>
    <div class="modal-body">
      <form id="form_detalle" class="form-horizontal">
        <input type="hidden" name="requisicion_id" value="{{$requisicion->id}}">
      @include('requisiciones.detalle.formulario')
      </form>
    </div>
    <div class="modal-footer">
      <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="button" id="agregar_otro" class="btn btn-success">Agregar</button></center>
    </div>
  </div>
  </div>
</div>