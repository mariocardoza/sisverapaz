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
<div class="">
    <div class="row">
        <div class="col-md-9">
          <div class="btn-group">
            <button class="btn btn-primary que_ver" data-tipo="1" >Requisiciones</button>
            @if(Auth()->user()->hasRole('uaci'))
            <button class="btn btn-primary que_ver" data-tipo="2">Solicitudes</button>
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
                <?php if(App\Requisicione::tiene_materiales($requisicion->id)): ?>
                  <center>
                    <button class="btn btn-primary pull-right" id="registrar_solicitud">Registrar</button>
                  </center>
                <?php endif; ?>
                <div class="row">
                  <div class="col-xs-2">
                    <div class="col-sm-12">
                      <span>&nbsp</span>
                    </div>
                    @foreach($requisicion->solicitudcotizacion as $soli)
                    <button data-id="{{$soli->id}}" id="lasolicitud" class="btn btn-primary col-sm-12">{{$soli->numero_solicitud}}</button>
                    @if(!$loop->last)
                      <div class="clearfix"></div>
                      <hr style="margin-top: 3px; margin-bottom: 3px;">
                    @endif
                    @endforeach
                  </div>
                  <div class="col-xs-9" id="aquilasoli">
                    
                  </div>
                </div>
               
                <!--table class="table" >
                  <thead>
                    <tr>
                      <td>Número de solicitud</td>
                      <td>Encargado</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach ($requisicion->solicitudcotizacion as $soli)
                        <tr>
                        <td>{{$soli->numero_solicitud}}</td>
                        <td>{{$soli->encargado}}</td>
                          <td>
                            <div class="pull-right">
                                <a title="Imprimir solicitud de cotización" href="{{url('reportesuaci/solicitud/'.$soli->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                                @if(date("Y-m-d") > $soli->fecha_limite->format('Y-m-d') && ($requisicion->estado != 4 && $requisicion->estado != 5 && $requisicion->estado != 6 && $requisicion->estado != 7))
                                <a href="{{url('/cotizaciones/cotizarr/'.$soli->id)}}" class="btn btn-primary pull-right">Ver cuadro comparativo</a>
                                @else
                                  @if($soli->estado==1)
                                  <a href="javascript:void(0)" id="registrar_cotizacion" data-id="{{$soli->id}}" class="btn btn-primary pull-right">este</a>
                                  @elseif($soli->estado==4)
                                    @if(isset($soli->cotizacion_seleccionada->ordencompra))
                                    <a href="{{url('/reportesuaci/ordencompra/'.$soli->cotizacion_seleccionada->ordencompra->id)}}" class="btn btn-primary pull-right" target="_blank"><i class="fa fa-print"></i></a>
                                    @else
                                      <button data-id="{{$soli->cotizacion_seleccionada->id}}" class="btn btn-primary" id="registrar_orden">Registrar</button>    
                                    @endif
                                  @endif
                                @endif
                              </div>
                         </td>
                        </tr>
                        <tr colspan="3">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="3">Cotizaciones</th>
                                      </tr>
                                  <tr>
                                  <th>Proveedor</th>
                                  <th>Forma de pago</th>
                                  <th></th>
                                  </tr>
                                  
                                </thead>
                                <tbody>
                                  @foreach($soli->cotizacion as $cotizacion)
                                  <tr>
                                    <td>{{$cotizacion->proveedor->nombre}}</td>
                                    <td>{{$cotizacion->formapago->nombre}}</td>
                                    <td>
                                      <button class="btn btn-primary btn-sm pull-right"  type="button"><i class="fa fa-eye"></i></button>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                        </tr>
                        <tr>
                          <th colspan="3"><hr></th>
                        </tr>
                    @endforeach
                  </tbody>
                </table-->
           
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
                    <button class="btn btn-primary pull-right" id="registrar_cotizacion">Registrar</button>
                  <?php elseif($requisicion->estado > 5): ?>
                    <a class="btn btn-primary pull-left" href="{{ url('reportesuaci/cotizaciones/'.$requisicion->id)}}" target="_blank"><i class="fa fa-print"></i></a>
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
                  <button class="btn btn-primary" id="registrar_cotizacione">Registrar</button>
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
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-primary">
              <div class="panel-heading">Información sobre la requisición <b>{{$requisicion->codigo_requisicion}}<b> </div>
              <div class="panel-body">
                <div class="pull-right">
                  @if($requisicion->estado==5)
                    <a title="Materiales recibidos" href="javascript:void(0)" class="btn btn-primary" id="materiales_recibidos"><i class="glyphicon glyphicon-check"></i></a>
                  @elseif($requisicion->estado==6)
                  <a title="Finalizar" href="javascript:void(0)" class="btn btn-primary" id="terminar_proceso"><i class="glyphicon glyphicon-check"></i></a>
                  @elseif($requisicion->estado==7)
                  <a title="Descargar" href="{{ url('requisiciones/bajar/'.$requisicion->nombre_archivo) }}" class="btn btn-primary" id=""><i class="glyphicon glyphicon-download"></i></a>
                  @else
                    <a title="Imprimir requisición" href="{{url('reportesuaci/requisicionobra/'.$requisicion->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                  @endif
                </div>
                <br><br>
                <div class="col-sm-12">
                  <span><center>{!! $elestado !!}</center></span>
                </div>
                <div class="clearfix"></div>
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                  <span style="font-weight: normal;">Requisición N°:</span>
                </div>
                <div class="col-sm-12">
                  <span><b>{{ $requisicion->codigo_requisicion}}</b></span>
                </div>
                <div class="clearfix"></div>
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                  <span style="font-weight: normal;">Actividad:</span>
                </div>
                <div class="col-sm-12">
                  <span><b>{{$requisicion->actividad}}</b></span>
                </div>
                <div class="clearfix"></div>
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                  <span style="font-weight: normal;">Responsable:</span>
                </div>
                <div class="col-sm-12">
                  <span><b>{{$requisicion->user->empleado->nombre}}</b></span>
                </div>
                <div class="clearfix"></div>
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                  <span style="font-weight: normal;">Fuente de financiamiento:</span>
                </div>
                <div class="col-sm-12">
                  <span><b>{{$requisicion->fondocat->categoria}}</b></span>
                </div>
                <div class="clearfix"></div>
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                  <span style="font-weight: normal;">Unidad solicitante:</span>
                </div>
                <div class="col-sm-12">
                  <span><b>{{$requisicion->unidad->nombre_unidad}}</b></span>
                </div>
                <div class="clearfix"></div>
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-xs-12">
                  <span style="font-weight: normal;">Observaciones:</span>
                </div>
                <div class="col-xs-12">
                  <span><b>{{$requisicion->observaciones}}</b></span>
                </div>
                

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
