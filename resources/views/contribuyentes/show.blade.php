@extends('layouts.app')

@section('migasdepan')
    <h1>

        <small>Ver Contribuyente <b>{{ $contribuyente->nombre }}</b></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/contribuyentes') }}"><i class="fa fa-dashboard"></i> Usuarios</a></li>
        <li class="active">Ver</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
                <div class="panel panel-primary">
                    <div class="panel-heading">Datos del Contribuyente </div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$contribuyente->nombre}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$contribuyente->direccion}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
                            <label for="dui" class="col-md-4 control-label">DUI: </label>
                            <label for="nombre" class="col-md-4 control-label"> {{$contribuyente->dui}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                            <label for="nit" class="col-md-4 control-label">NIT: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$contribuyente->nit}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
                            <label for="sexo" class="col-md-4 control-label">Sexo:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$contribuyente->sexo}}</label><br>
                        </div>

                        <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                            <label for="telefono" class="col-md-4 control-label">Teléfono: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$contribuyente->telefono}}</label><br>

                        </div>

                        {{ Form::open(['route' => ['contribuyentes.destroy', $contribuyente->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('contribuyentes/'.$contribuyente->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span> Editar</a> |
                        <button class="btn btn-danger" type="button" onclick="
                        return swal({
                          title: 'Eliminar contribuyente',
                          text: '¿Está seguro de eliminar contribuyente?',
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
