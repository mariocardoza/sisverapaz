<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_subir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Subir documento</h4>
        </div>
        <div class="modal-body">
            <form id='form_subir' enctype="multipart/form-data">
              <input type="hidden" name="contratacion_id" value="{{$compra->id}}">
              <div class="form-group">
                <label for="" class="control-label">Nombre</label>
                <div>
                  <input type="text" class="form-control" name="nombre" autocomplete="off" placeholder="Nombre del contrato">
                </div>
              </div>
  
              <label for="file-upload" class="subir">
                <i class="glyphicon glyphicon-cloud"></i> Subir archivo
            </label>
            <input id="file-upload" onchange='cambiar()' name="archivo" type="file" style='display: none;'/>
            <div id="info"></div>
                <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit"  class="btn btn-primary">Guardar</button></center>
            </form>
        </div>
        <!--div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="agregar_orden" class="btn btn-success">Agregar</button></center>
        </div-->
      </div>
      </div>
  </div>
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_proveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Seleccionar proveedor</h4>
        </div>
        <div class="modal-body">
            <form id='form_proveedor'>
              <input type="hidden" name="id" value="{{$compra->id}}">
              <div class="form-group">
                <label for="" class="control-label">Seleccione un proveedor</label>
                <select name="proveedor_id" id="elprove" class="chosen-select-width">
                  <option value="">Seleccione..</option>
                  @foreach ($proveedores as $p)
                    <option  value="{{$p->id}}">{{$p->nombre}}</option>
                  @endforeach
                </select>
                <button class="btn btn-primary nuevo_prov"><i class="fa fa-plus"></i></button>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Forma de pago</label>
                <select name="formapago" id="" class="chosen-select-width">
                  <option value="">Seleccione </option>
                  @foreach ($formas as $f)
                      <option value="{{$f->id}}">{{$f->nombre}}</option>
                  @endforeach
                </select>
              </div>
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit"  class="btn btn-success">Seleccionar</button></center>
        </div>
      </form>
      </div>
      </div>
  </div>
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="nuevo_proveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nuevo proveedor</h4>
        </div>
        <div class="modal-body">
            <form id='form_nproveedor'>
              <div class="row">
                @include('proveedores.formulario')
              </div>
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" id="cierra_modal">Cerrar</button>
            <button type="submit"  class="btn btn-primary">Guardar</button></center>
        </div>
      </form>
      </div>
      </div>
  </div>

  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_unidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nuevo unidad de medida</h4>
        </div>
        <div class="modal-body">
            <form id='form_unidadmedida'>
              <div class="row">
                @include('unidadmedidas.formulario')
              </div>
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit"  class="btn btn-success">Guardar</button></center>
        </div>
      </form>
      </div>
      </div>
  </div>

  <div class="modal fade" tabindex="-1" id="modal_material" role="dialog" aria-labelledby="gridSystemModalLabel">
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
          
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Registrar</button></center>
        </div>
      </form>
      </div>
    </div>
  </div>