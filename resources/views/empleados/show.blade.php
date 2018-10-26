@extends('layouts.app')

@section('migasdepan')
<h1>

        <small>Ver empleado <b>{{ $empleado->nombre }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/empleados') }}"><i class="fa fa-dashboard"></i> Empleados</a></li>
        <li class="active">Ver</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos del empleado </div>
                <div class="panel-body">
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre del empleado: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->nombre}}</label><br>

                        </div>

                         <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
                            <label for="dui" class="col-md-4 control-label">Número de DUI: </label>
                            <label for="nombre" class="col-md-4 control-label"> {{$empleado->dui}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                            <label for="nit" class="col-md-4 control-label">Número de NIT: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->nit}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
                            <label for="sexo" class="col-md-4 control-label">Sexo:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->sexo}}</label><br>
                        </div>

                        <div class="form-group{{ $errors->has('telefono_fijo') ? ' has-error' : '' }}">
                            <label for="telefono_fijo" class="col-md-4 control-label">Número de teléfono:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->telefono_fijo}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                            <label for="celular" class="col-md-4 control-label">Número de celular:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->celular}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->direccion}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('num_cuenta') ? ' has-error' : '' }}">
                            <label for="num_cuenta" class="col-md-4 control-label">Número de cuenta:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->num_cuenta}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('num_contribuyente') ? ' has-error' : '' }}">
                            <label for="num_contribuyente" class="col-md-4 control-label">Número de contribuyente:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->num_contribuyente}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('num_seguro_social') ? ' has-error' : '' }}">
                            <label for="num_seguro_social" class="col-md-4 control-label">Número de Seguro Social:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->num_seguro_social}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('num_afp') ? ' has-error' : '' }}">
                            <label for="num_afp" class="col-md-4 control-label">Número de AFP:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$empleado->num_afp}}</label><br>

                        </div>

                      {{ Form::open(['route' => ['empleados.destroy', $empleado->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('empleados/'.$empleado->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span> Editar</a> |
                        <button class="btn btn-danger" type="button" onclick="
                        return swal({
                          title: 'Eliminar empleado',
                          text: '¿Está seguro de eliminar empleado?',
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
