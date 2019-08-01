@extends('layouts.app')

@section('migasdepan')
<h1>
        Ver requisicion <small>{{$requisicion->justificacion}}</small>
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
                <div class="panel-heading">Datos de la requisición </div>
                <div class="panel-body">
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Unidad administrativa: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$requisicion->unidad_admin}}</label><br>

                        </div>

                         <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
                            <label for="monto" class="col-md-4 control-label">Linea de trabajo: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$requisicion->linea_trabajo}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('fuente_financiamiento') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Fuente de financiamiento: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$requisicion->fuente_financiamiento}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('fecha_inicio') ? ' has-error' : '' }}">
                            <label for="fecha_inicio" class="col-md-4 control-label">Justificación: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$requisicion->justificacion}}</label><br>

                        </div>
                        <br>
                        <a class="btn btn-success" href="{{url('requisiciondetalles/create/'.$requisicion->id)}}">Agregar Necesidad</a>
                        <div>
                          <table class="table">
                            <thead>
                              <th>Código</th>
                              <th>Cantidad</th>
                              <th>Unidad de medida</th>
                              <th>Descripción</th>
                              <th>Acción</th>
                            </thead>
                            <tbody>
                              @foreach($detalles as $detalle)
                              <tr>
                                <td>{{$detalle->codigo}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td>{{$detalle->unidad_medida}}</td>
                                <td>{{$detalle->descripcion}}</td>
                                <td>
                                  {{ Form::open(['route' => ['requisiciondetalles.destroy', $detalle->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                                  <a href="{{url('requisiciondetalles/'.$detalle->id.'/edit')}}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span></a>
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
                                    })";><span class="glyphicon glyphicon-trash"></span></button>
                                  {{ Form::close()}}
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>

                      {{ Form::open(['route' => ['requisiciones.destroy', $requisicion->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('/requisiciones/'.$requisicion->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span> Editar</a> |
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
