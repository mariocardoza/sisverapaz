@php
    $lacuentas=\App\Cuenta::where('estado',1)->get();
    $cuentas=[];
    foreach($lacuentas as $item){
      $cuentas[$item->id]=$item->nombre;
    }
@endphp
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

<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_subir_contrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Subir contrato</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['action'=>'RequisicionController@subircontrato', 'class' => '','id' => 'form_subircontrato','enctype'=>'multipart/form-data']) }}
            <input type="hidden" name="requisicion_id" value="{{$requisicion->id}}">
            <div class="form-group">
              <label for="" class="control-label">Nombre</label>
              <div>
                <input type="text" class="form-control" name="nombre" autocomplete="off" placeholder="Nombre del contrato">
              </div>
            </div>
            <div class="form-group">
              <label for="" class="control-label">Descripción</label>
              <div>
                <input type="text" class="form-control" name="descripcion" autocomplete="off" placeholder="Nombre del contrato">
              </div>
            </div>
            <label for="file-upload" class="subir">
              <i class="glyphicon glyphicon-cloud"></i> Subir archivo
          </label>
          <input id="file-upload" onchange='cambiar()' name="archivo" type="file" style='display: none;'/>
          <div id="info3"></div>
              <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit"  class="btn btn-success">Guardar</button></center>
        {{Form::close()}}
      </div>
      <!--div class="modal-footer">
        <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="agregar_orden" class="btn btn-success">Agregar</button></center>
      </div-->
    </div>
    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_aprobar_requisicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-sm">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Aprobar requisición</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['action'=>'RequisicionController@aprobar', 'class' => '','id' => 'form_aprobarrequi','enctype'=>'multipart/form-data']) }}
              <input type="hidden" name="requisicion_id" value="{{$requisicion->id}}">
              <label for="" class="control-label">Para aprobar la requisición debe seleccionar una fuente de financiamiento</label>
              <div class="form-group">
                <label for="" class="control-label"></label>
                <div>
                  {!! Form::select('cuenta_id',$cuentas,null,['class'=>'chosen-select-width','placeholder'=>'seleccione la fuente e financiamiento','required'=>'required']) !!}
                </div>
              </div>
          
          {{Form::close()}}
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="aprobar_requisicion" class="btn btn-success">Agregar</button></center>
        </div>
      </div>
      </div>
    </div>