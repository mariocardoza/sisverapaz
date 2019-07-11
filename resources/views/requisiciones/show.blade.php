@extends('layouts.app')

@section('migasdepan')
<h1>
        &nbsp;
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/requisiciones') }}"><i class="fa fa-balance-scale"></i> Requisiciones</a></li>
        <li class="active">Ver</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Información sobre la requisición <b>{{$requisicion->codigo_requisicion}}<b> </div>
                <div class="panel-body">
                  <div class="pull-right">
                    @if($requisicion->estado==5)
                      <a title="Materiales recibidos" href="javascript:void(0)" class="btn btn-primary" id="materiales_recibidos"><i class="glyphicon glyphicon-check"></i></a>
                    @elseif($requisicion->estado==6)
                    <a title="Acta"  href="{{url('reportesuaci/acta/'.$requisicion->solicitudcotizacion->cotizacion_seleccionada->ordencompra->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                    <a title="Finalizar" href="javascript:void(0)" class="btn btn-primary" id="terminar_proceso"><i class="glyphicon glyphicon-check"></i></a>
                    @else
                      <a title="Imprimir requisición" href="{{url('reportesuaci/requisicionobra/'.$requisicion->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                    @endif
                  </div>
                    <table class="table">
                      <tr>
                        <th colspan="2">
                          <center>{!! $elestado !!}</center>
                        </th>
                      </tr>
                      <tr>
                        <th>Requisición N°</th>
                        <td>{{ $requisicion->codigo_requisicion}}</td>
                      </tr>
                       <tr>
                        <th>Actividad</th>
                        <td>{{$requisicion->actividad}}</td>
                      </tr>
                      <tr>
                        <th>Responsable</th>
                        <td>{{$requisicion->user->empleado->nombre}}</td>
                      </tr>
                      <tr>
                        <th>Fuente de financiamiento</th>
                        <td>{{$requisicion->fondocat->categoria}}</td>
                      </tr>
                      <tr>
                        <th>Unidad solicitante</th>
                        <td>{{$requisicion->unidad->nombre_unidad}}</td>
                      </tr>
                      <tr>
                        <th>Observaciones</th>
                        <td>{{$requisicion->observaciones}}</td>
                      </tr>
                    </table>

                        <br>
                        
                        <center>
                        @if($requisicion->estado==1)
                      {{ Form::open(['route' => ['requisiciones.destroy', $requisicion->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('/requisiciones/'.$requisicion->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Editar</a> |
                        <button class="btn btn-danger" type="button" onclick="
                        return swal({
                          title: 'Eliminar requisicion',
                          text: '¿Está seguro de eliminar requisicion?',
                          type: 'question',
                          showCancelButton: true,
                          confirmButtonText: 'Si, Eliminar',
                          cancelButtonText: 'No, Mantener',
                          confirmButtonClass: 'btn btn-danger',
                          cancelButtonClass: 'btn btn-default',
                          buttonsStyling: false
                        }).then(function(){
                          submit();
                          swal('Hecho', 'El registro a sido eliminado','success')
                        }, function(dismiss){
                          if(dismiss == 'cancel'){
                            swal('Cancelado', 'El registro se mantiene','info')
                          }
                        })";><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
                      {{ Form::close()}}
                    @endif
                  </center>
                </div>
            </div>
        </div>

        <div class="col-md-7">
          <div class="btn-group">
            <button class="btn btn-primary que_ver" data-tipo="1" >Requisiciones</button>
            @if(Auth()->user()->hasRole('uaci'))
            <button class="btn btn-primary que_ver" data-tipo="2">Solicitud</button>
            <button class="btn btn-primary que_ver" data-tipo="3">Cotizaciones</button>
            <button class="btn btn-primary que_ver" data-tipo="4">Orden de compra</button>
            @endif
          </div><br><br>
          <div class="panel panel-primary" id="requi" style="display: block;">
            <div class="panel-heading">Detalle</div>
            <div class="panel-body" id="body_requi">
              <div>
                <?php if($requisicion->requisiciondetalle->count() > 0): ?>

                    @if($requisicion->estado==1)
                      <center><a class="btn btn-success pull-right" id="agregar_nueva">Agregar Necesidad</a></center><br>
                    @else
                    <a title="Imprimir requisición" href="{{url('reportesuaci/requisicionobra/'.$requisicion->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                    @endif
                          <table class="table estee" id="tabla_requi">
                            <thead>
                              <th>Descripción</th>
                              <th>Cantidad</th>
                              <th>Unidad de medida</th>
                              <th></th>
                            </thead>
                            <tbody>
                              @foreach($requisicion->requisiciondetalle as $detalle)
                              <tr>
                                <td>{{$detalle->material->nombre}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td>{{$detalle->unidadmedida->nombre_medida}}</td>
                                <td>
                                  @if($requisicion->estado==1)
                                  {{ Form::open(['route' => ['requisiciondetalles.destroy', $detalle->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                                    <div class="btn-group">
                                      <a id="editar_detalle" data-id="{{$detalle->id}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                                        <button class="btn btn-danger btn-xs" type="button" onclick="
                                        return swal({
                                          title: 'Eliminar requisicion',
                                          text: '¿Está seguro de eliminar requisicion?',
                                          type: 'question',
                                          showCancelButton: true,
                                          confirmButtonText: 'Si, Eliminar',
                                          cancelButtonText: 'No, Mantener',
                                          confirmButtonClass: 'btn btn-danger',
                                          cancelButtonClass: 'btn btn-default',
                                          buttonsStyling: false
                                        }).then(function(){
                                          submit();
                                          swal('Hecho', 'El registro a sido eliminado','success')
                                        }, function(dismiss){
                                          if(dismiss == 'cancel'){
                                            swal('Cancelado', 'El registro se mantiene','info')
                                          }
                                        })";><span class="glyphicon glyphicon-trash"></span></button>
                                    </div>
                                  {{ Form::close()}}
                                @endif
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          <?php else: ?>
                            <center>
                              <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                              <span>Agregue requerimientos de materiales</span><br>
                              <button class="btn btn-primary" id="agregar_nueva">Agregar</button>
                            </center>
                      <?php endif; ?>
                        </div>
            </div>
          </div>
          <div class="panel panel-primary" id="soli" style="display: none;">
            <div class="panel-heading">Solicitud de cotización</div>
            <div class="panel">
              <?php if($requisicion->solicitudcotizacion): ?>
                <div class="pull-right">
                    <a title="Imprimir solicitud de cotización" href="{{url('reportesuaci/solicitud/'.$requisicion->solicitudcotizacion->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                  </div>
                  <table class="table">
                    <tr>
                      <td>Número de solicitud</td>
                      <th>{{$requisicion->solicitudcotizacion->numero_solicitud}}</th>
                    </tr>
                    <tr>
                      <td>Encargado</td>
                      <th>{{$requisicion->solicitudcotizacion->encargado}}</th>
                    </tr>
                    <tr>
                      <td>Cargo</td>
                      <th>{{$requisicion->solicitudcotizacion->cargo_encargado}}</th>
                    </tr>
                    <tr>
                      <td>Lugar de entrega</td>
                      <th>{{$requisicion->solicitudcotizacion->lugar_entrega}}</th>
                    </tr>
                    <tr>
                      <td>Fecha límite para cotizar</td>
                      <th>{{$requisicion->solicitudcotizacion->fecha_limite->format("d/m/Y")}}</th>
                    </tr>
                    <tr>
                      <td>Tiempo máximo para entrega de materiales</td>
                      <th>{{$requisicion->solicitudcotizacion->tiempo_entrega}}</th>
                    </tr>
                  </table>
              <?php else: ?>
                <center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>Registre la solicitud</span><br>
                  <button class="btn btn-primary" id="registrar_solicitud">Registrar</button>
                </center>
              <?php endif; ?>
              
              
            </div>
          </div>
          <div class="panel panel-primary" id="coti" style="display: none;">
            <div class="panel-heading">Cotizaciones</div>
            <div class="panel">
              <?php if (isset($requisicion->solicitudcotizacion->cotizacion)): ?>
                <?php if (date("Y-m-d") > $requisicion->solicitudcotizacion->fecha_limite->format('Y-m-d') && ($requisicion->estado != 4 && $requisicion->estado != 5 && $requisicion->estado != 6 && $requisicion->estado != 7)): ?>
                  <a href="{{url('/cotizaciones/cotizarr/'.$requisicion->solicitudcotizacion->id)}}" class="btn btn-primary pull-right">Ver cuadro comparativo</a>
                <?php else: ?>
                  <?php if($requisicion->estado==3):?>
                    <center><button class="btn btn-primary pull-right" id="registrar_cotizacion">Registrar</button></center>
                  <?php endif; ?>
                <?php endif ?>
                <table class="table" id="example2">
                    <thead>
                      <tr>
                      <th>Proveedor</th>
                      <th>Forma de pago</th>
                      <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($requisicion->solicitudcotizacion->cotizacion as $cotizacion)
                      <tr>
                        <th>{{$cotizacion->proveedor->nombre}}</th>
                        <th>{{$cotizacion->formapago->nombre}}</th>
                        <th>
                          <button class="btn btn-primary btn-sm" id="ver_coti" data-id="{{$cotizacion->id}}" type="button"><i class="fa fa-eye"></i></button>
                        </th>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
            
               
              <?php else: ?>
                 @if(isset($requisicion->solicitudcotizacion))
                 <center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>Registre las cotizaciones</span><br>
                  <button class="btn btn-primary" id="registrar_cotizacion">Registrar</button>
                </center>
                  @else
                  <center>
                    <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <span>Registre primero la solicitud de cotización</span><br>
                    
                  </center>
                  @endif
              <?php endif; ?>
              
              
            </div>
          </div>
          <div class="panel panel-primary" id="orden" style="display: none;">
            <div class="panel-heading">Orden de compra</div>
            <div class="panel">
              @if(isset($requisicion->solicitudcotizacion->cotizacion_seleccionada->ordencompra))
              <a href="{{ url('/reportesuaci/ordencompra/'.$requisicion->solicitudcotizacion->cotizacion_seleccionada->ordencompra->id) }}" class="btn btn-primary pull-right" target="_blank"><i class="fa fa-print"></i></a>
              <table class="table">
                <tr>
                  <td>Número de orden</td>
                  <th>{{$requisicion->solicitudcotizacion->cotizacion_seleccionada->ordencompra->numero_orden}}</th>
                </tr>
                <tr>
                  <td>Proveedor seleccionado</td>
                  <th>{{$requisicion->solicitudcotizacion->cotizacion_seleccionada->proveedor->nombre}}</th>
                </tr>
                <tr>
                  <td>Dirección de entrega</td>
                  <th>{{$requisicion->solicitudcotizacion->cotizacion_seleccionada->ordencompra->direccion_entrega}}</th>
                </tr>
                <tr>
                  <td>Administrador de la orden</td>
                  <th>{{$requisicion->solicitudcotizacion->cotizacion_seleccionada->ordencompra->adminorden}}</th>
                </tr>
              </table>
              @else
              @if(isset($requisicion->solicitudcotizacion->cotizacion_seleccionada))
                <center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>Aun no se ha registrado la orden de compra</span><br>
                  <button class="btn btn-primary" id="registrar_orden">Registrar</button>
                </center>
                @else
                  <center>
                    <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <span>Se estan recibiendo cotizaciones</span><br>
                  </center>
                @endif
              @endif
            </div>
          </div>
        </div>
    </div>
    <div id="modal_aqui"></div>
</div>
@include('requisiciones.modales')
@endsection
@section('scripts')
<script>
  var elid='<?php echo $requisicion->id ?>';
</script>
{!! Html::script('js/requisicion_show.js?cod='.date('Yidisus')) !!}
@endsection
