@extends('layouts.app')

@section('migasdepan')
<h1>
        Requisición <small>{{$requisicion->actividad}}</small>
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
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Información sobre la requisición {{$requisicion->codigo_requisicion}} </div>
                <div class="panel-body">
                  <div class="pull-right">
                    <a title="Imprimir requisición" href="{{url('reportesuaci/requisicionobra/'.$requisicion->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                  </div>
                    <table class="table">
                      <tr>
                        <th>Requisición N°</th>
                        <td>{{ $requisicion->codigo_requisicion}}</td>
                      </tr>
                      <tr>
                        <th>Responsable</th>
                        <td>{{$requisicion->user->empleado->nombre}}</td>
                      </tr>
                      <tr>
                        <th>Actividad</th>
                        <td>{{$requisicion->actividad}}</td>
                      </tr>
                      <tr>
                        <th>Fuente de financiamiento</th>
                        <td>{{$requisicion->fondocat->categoria}}</td>
                      </tr>
                      <tr>
                        <th>Unidad solicitante</th>
                        <td>{{$requisicion->user->roleuser->role->description}}</td>
                      </tr>
                      <tr>
                        <th>Observaciones</th>
                        <td>{{$requisicion->observaciones}}</td>
                      </tr>
                    </table>

                        <br>
                        @if($requisicion->estado==1)
                          <a class="btn btn-success" href="{{url('requisiciondetalles/create/'.$requisicion->id)}}">Agregar Necesidad</a>
                        @endif
                        <div>
                          <table class="table">
                            <thead>
                              <th>Cantidad</th>
                              <th>Unidad de medida</th>
                              <th>Descripción</th>
                              <th>Acción</th>
                            </thead>
                            <tbody>
                              @foreach($requisicion->requisiciondetalle as $detalle)
                              <tr>
                                <td>{{$detalle->cantidad}}</td>
                                <td>{{$detalle->unidad_medida}}</td>
                                <td>{{$detalle->descripcion}}</td>
                                <td>
                                  @if($requisicion->estado==1)
                                  {{ Form::open(['route' => ['requisiciondetalles.destroy', $detalle->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                                    <div class="btn-group">
                                      <a href="{{url('requisiciondetalles/'.$detalle->id.'/edit')}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
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
                        </div>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
