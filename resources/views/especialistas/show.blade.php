@extends('layouts.app')

@section('migasdepan')
<h1>

        <small>Ver información <b>{{ $especialista->nombre }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/especialistas') }}"><i class="fa fa-dashboard"></i> Especialista</a></li>
        <li class="active">Ver</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos del especialista </div>
                <div class="panel-body">
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre del especialista: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$especialista->nombre}}</label><br>

                        </div>

                         <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
                            <label for="dui" class="col-md-4 control-label">Número de DUI: </label>
                            <label for="nombre" class="col-md-4 control-label"> {{$especialista->dui}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                            <label for="nit" class="col-md-4 control-label">Número de NIT: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$especialista->nit}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
                            <label for="sexo" class="col-md-4 control-label">Sexo:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$especialista->sexo}}</label><br>
                        </div>

                        <div class="form-group{{ $errors->has('telefono_fijo') ? ' has-error' : '' }}">
                            <label for="telefono_fijo" class="col-md-4 control-label">Número de teléfono:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$especialista->telefono_fijo}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                            <label for="celular" class="col-md-4 control-label">Número de celular:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$especialista->celular}}</label><br>
                        </div>

                        <div class="form-group{{ $errors->has('emaile') ? ' has-error' : '' }}">
                            <label for="emaile" class="col-md-4 control-label">E-Mail Especialista: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$especialista->email}}</label>
                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$especialista->direccion}}</label><br>
                        </div>

                      {{ Form::open(['route' => ['especialistas.destroy', $especialista->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('especialistas/'.$especialista->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span> Editar</a> |
                        <button class="btn btn-danger" type="button" onclick="
                        return swal({
                          title: 'Eliminar especialista',
                          text: '¿Está seguro de eliminar especialista?',
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
