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
                        <td>{{$detalle->descripcion}}</td>
                        <td>{{$detalle->unidadmedida->nombre_medida}}</td>
                        <td>{{$detalle->cantidad}}
                          <input type='hidden' name='unidades[]' value='{{$detalle->unidad_medida}}'/>
                          <input type='hidden' name='descripciones[]' value='{{$detalle->descripcion}}'/>
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