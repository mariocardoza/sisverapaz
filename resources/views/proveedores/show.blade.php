@extends('layouts.app')

@section('migasdepan')
<h1>
  Ver proveedor:
        <small><b>{{ $proveedor->nombre }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proveedores') }}"><i class="fa fa-user-circle-o"></i> Proveedores</a></li>
        <li class="active">Ver proveedor</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos del Proveedor </div>
                <div class="panel-body">
                        <div class="form-group">
                            <label for="nombree" class="col-md-4 control-label">Nombre de la Empresa o Proveedor: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$proveedor->nombre}}</label>
                        </div><br>

                         <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección: </label>
                            <label for="nombree" class="col-md-8 control-label">{{$proveedor->direccion}}</label>
                        </div><br>

                        <div class="form-group{{ $errors->has('telefonoe') ? ' has-error' : '' }}">
                            <label for="telefonoe" class="col-md-4 control-label">Telefono de la Empresa o Proveedor: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$proveedor->telefono}}</label>
                        </div><br>

                        <div class="form-group{{ $errors->has('emaile') ? ' has-error' : '' }}">
                            <label for="emaile" class="col-md-4 control-label">E-Mail Proveedor: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$proveedor->email}}</label>
                        </div><br>

                        <div class="form-group{{ $errors->has('nombrer') ? ' has-error' : '' }}">
                            <label for="nombrer" class="col-md-4 control-label">Nombre de Represetante: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$proveedor->nombrer}}</label>
                        </div><br>

                        <div class="form-group{{ $errors->has('telfijor') ? ' has-error' : '' }}">
                            <label for="telfijor" class="col-md-4 control-label">Telefono fijo Representante (si lo hay): </label>
                            <label for="nombree" class="col-md-4 control-label">{{$proveedor->teldijor}}</label>
                        </div><br>

                        <div class="form-group{{ $errors->has('celr') ? ' has-error' : '' }}">
                            <label for="celr" class="col-md-4 control-label">Celular Representante: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$proveedor->celr}}</label>
                        </div><br>

                        <div class="form-group{{ $errors->has('emailr') ? ' has-error' : '' }}">
                            <label for="emailr" class="col-md-4 control-label">Dirección email del Representante:</label>
                            <label for="nombree" class="col-md-4 control-label">{{$proveedor->emailr}}</label>
                        </div><br>

                      {{ Form::open(['route' => ['proveedores.destroy', $proveedor->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('/proveedores/'.$proveedor->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span> Editar</a> |
                        <button class="btn btn-danger" type="button" onclick="
                        return swal({
                          title: 'Eliminar proveedor',
                          text: '¿Está seguro de eliminar proveedor?',
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
