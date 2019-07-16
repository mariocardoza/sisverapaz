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
      <button type="button" id="agregar_soli" class="btn btn-success">Agregar</button></center>
    </div>
  </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_coti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Registrar cotizacion</h4>
    </div>
    <div class="modal-body">
                  {{ Form::open([ 'class' => 'form-horizontal','id'=>'form_coti']) }}

            <div class="form-group{{ $errors->has('proveedor') ? ' has-error' : '' }}">
                <label for="" class="col-md-4 control-label">Proveedor</label>
                <div class="col-md-6">
                    <select name="proveedor" id="proveedor" class="chosen-select-width">
                        <option value="">Seleccione un proveedor</option>
                        @foreach($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalproveedor"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>

            <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                <label for="descripcion" class="col-md-4 control-label">Forma de pago</label>

                <div class="col-md-6">
                  @if(isset($requisicion->solicitudcotizacion))
                    {!!Form::hidden('id',$requisicion->solicitudcotizacion->id,['id'=>'id'])!!}
                  @endif
                    <select class="chosen-select-width laformapago" name="descripcion" id="formapago">
                      <option value="">Seleccione una forma de pago</option>
                    </select>
                </div>
                <div class="col-md-2">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalformapago"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped" id="tabla" display="block;">
                  <thead>
                      <tr>
                          <th width="50%">Descripción</th>
                          <th width="10%">Unidad de medida</th>
                          <th width="10%">Cantidad</th>
                          <th width="10%">Marca</th>
                          <th width="10%">Precio unitario</th>
                          <th width="10%">Total</th>
                      </tr>
                  </thead>
                  <tbody id="cuerpo">
                    @foreach($requisicion->requisiciondetalle as $detalle)
                      <tr>
                        <td>{{$detalle->material->nombre}}</td>
                        <td>{{$detalle->unidadmedida->nombre_medida}}</td>
                        <td>{{$detalle->cantidad}}
                          <input type='hidden' name='unidades[]' value='{{$detalle->unidad_medida}}'/>
                          <input type='hidden' name='descripciones[]' value='{{$detalle->material->nombre}}'/>
                          <input type='hidden' name='cantidades[]' value='{{$detalle->cantidad}}'/>
                        </td>
                        <td><input type="text" name="marcas[]" class="marcas form-control"/></td>
                        <td><input name="precios[]" data-cantidad={{$detalle->cantidad}} type="number" min="0.01" step="any" class="precios form-control"/></td>
                        <td class="subtotal">$0.00</td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>

           
            {{ Form::close() }}
    </div>
    <div class="modal-footer">
      <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="button" id="registrar_lacoti" class="btn btn-success">Agregar</button></center>
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
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_orden" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Registrar la orden de compra</h4>
    </div>
    <div class="modal-body">
      {{ Form::open(['class' => 'form-horizontal','id' => 'laordencompra']) }}
      @if(isset($requisicion->solicitudcotizacion->cotizacion_seleccionada))
          @include('ordencompras.formularior')

     @endif       
      {{Form::close()}}
    </div>
    <div class="modal-footer">
      <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="button" id="agregar_orden" class="btn btn-success">Agregar</button></center>
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