<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_detalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Necesidad de la requisicion</h4>
    </div>
    <div class="modal-body">
      <form id="form_detalle" class="form-horizontal">
        <input type="hidden" name="requisicion_id" class="elid" value="{{$requisicion->id}}">
        <table class="table" id="latabla">
          <thead>
            <tr>
              <th>N°</th>
              <th>Nombre</th>
              <th>Categoría</th>
              <th>Unidad de medida</th>
              <th>Cantidad</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="losmateriales">
            
          </tbody>
        </table>
      </form>
    </div>
    <!--div class="modal-footer">
      <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="button" id="agregar_otro" class="btn btn-success">Agregar</button></center>
    </div-->
  </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_soli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Registrar la solicitud</h4>
    </div>
    <div class="modal-body">
      {{ Form::open(['class' => 'form-horizontal','id' => 'solicitudcotizacion']) }}
          @include('solicitudcotizaciones.formularior')

                  
      {{Form::close()}}
    </div>
    <div class="modal-footer">
      <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="button" id="agregar_soli" class="btn btn-success">Agregar</button>
    </div>
  </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_ver_coti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="titulo_ver_coti"></h4>
    </div>
    <div class="modal-body">
      <table class="table">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Marca</th>
            <th>Unidad de medida</th>
            <th>Cantidad</th>
            <th>Precio</th>
          </tr>
        </thead>
        <tbody id="aqui_poner_coti">
          
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></center>
    </div>
  </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_finalizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Subir acta de cierre</h4>
    </div>
    <div class="modal-body">
      {{ Form::open(['action'=>'RequisicionController@subir', 'class' => 'form-horizontal','id' => 'subir','enctype'=>'multipart/form-data']) }}
          <input type="hidden" name="requisicion_id" value="{{$requisicion->id}}">
            <label for="archivo">
              <input type="file" required name="archivo">
            </label>
            <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-success">Agregar</button></center>
      {{Form::close()}}
    </div>
    <!--div class="modal-footer">
      <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="button" id="agregar_orden" class="btn btn-success">Agregar</button></center>
    </div-->
  </div>
  </div>
</div>