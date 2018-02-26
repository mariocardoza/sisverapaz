@extends('layouts.app')

@section('migasdepan')
<h1>
Ver datos del proyecto:
        <small> <b>{{ $proyecto->nombre }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Ver proyecto</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos del Proyecto </div>
                <div class="panel-body">
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre del Proyecto: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$proyecto->nombre}}</label><br>

                        </div>

                         <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
                            <label for="monto" class="col-md-4 control-label">Monto establecido para el proyecto: </label>
                            <label for="nombre" class="col-md-4 control-label">$ {{number_format($proyecto->monto,2)}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección donde se ejecutará: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$proyecto->direccion}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('fecha_inicio') ? ' has-error' : '' }}">
                            <label for="fecha_inicio" class="col-md-4 control-label">Fecha inicio: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$proyecto->fecha_inicio->format('d-m-Y')}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('fecha_fin') ? ' has-error' : '' }}">
                            <label for="fecha_fin" class="col-md-4 control-label">Fecha finalización: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$proyecto->fecha_fin->format('d-m-Y')}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('organizacion_id') ? ' has-error' : '' }}">
                            <label for="organizacion_id" class="col-md-4 control-label">Organización colaboradora: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$proyecto->fondo->monto}}</label><br>
                        </div>

                        <div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }}">
                            <label for="motivo" class="col-md-4 control-label">Motivo:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$proyecto->motivo}}</label><br>

                        </div>

                        <!--<div class="form-group{{ $errors->has('fechabaja') ? ' has-error' : '' }}">
                            <label for="fechabaja" class="col-md-4 control-label">Fecha baja:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$proyecto->fechabaja}}</label><br>

                        </div>-->
                        <div style="overflow-x:auto;">
{{--                           <table class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                              <tr>
                                <th>Material</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($detalles as $detalle)
                              <tr>
                                <td>{{$detalle->material}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td>$ {{number_format($detalle->preciou,2)}}</td>
                                <td>$ {{number_format($detalle->cantidad*$detalle->preciou,2)}}</td>
                                <td>
                                  {{ Form::open(['route' => ['paacdetalles.destroy', $detalle->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                                  <a href="{{url('paacdetalles/'.$detalle->id.'/edit')}}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span></a>
                                  <button class="btn btn-danger" type="button" onclick="
                                  return swal({
                                    title: 'Eliminar obra',
                                    text: '¿Está seguro de eliminar la obra?',
                                    type: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Si, Eliminar',
                                    cancelButtonText: 'No, Mantener',
                                    confirmButtonClass: 'btn btn-danger',
                                    cancelButtonClass: 'btn btn-default',
                                    buttonsStyling: false
                                  }).then(function(){
                                    submit();
                                  }, function(dismiss){
                                    if(dismiss == 'cancel'){
                                      swal('Cancelado', 'El registro se mantiene','info')
                                    }
                                  })" ; ><span class="glyphicon glyphicon-trash"></span></button>
                                  {{ Form::close()}}
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                              <tr>
                                  <th colspan="3">totales</th>
                                  <th>$ {{number_format($presupuesto->total,2)}}</th>
                              </tr>

                            </tfoot>
                          </table> --}}

                      {{ Form::open(['route' => ['proyectos.destroy', $proyecto->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('/proyectos/'.$proyecto->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span> Editar</a> |
                        <button class="btn btn-danger" type="button" onclick="
                        return swal({
                          title: 'Eliminar proyecto',
                          text: '¿Está seguro de eliminar proyecto?',
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
