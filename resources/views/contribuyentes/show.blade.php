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
                    <div class="panel-heading">Datos del Proveedor </div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('nombree') ? ' has-error' : '' }}">
                            <label for="nombree" class="col-md-4 control-label">Nombre de la Empresa o Proveedor: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$contribuyente->nombre}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$contribuyente->direccion}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('telefonoe') ? ' has-error' : '' }}">
                            <label for="telefonoe" class="col-md-4 control-label">Telefono de la Empresa o Proveedor: </label>
                            <label for="nombree" class="col-md-4 control-label">{{$contribuyente->telefono}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('emaile') ? ' has-error' : '' }}">
                            <label for="emaile" class="col-md-4 control-label">E-Mail Proveedor: </label>
                            <label for="nombree" class="col-md-4 control-label"></label><br>

                        </div>

                        <div class="form-group{{ $errors->has('nombrer') ? ' has-error' : '' }}">
                            <label for="nombrer" class="col-md-4 control-label">Nombre de Represetante: </label>
                            <label for="nombree" class="col-md-4 control-label"></label><br>

                        </div>

                        <div class="form-group{{ $errors->has('telfijor') ? ' has-error' : '' }}">
                            <label for="telfijor" class="col-md-4 control-label">Telefono fijo Representante (si lo hay): </label>
                            <label for="nombree" class="col-md-4 control-label"></label><br>

                        </div>

                        <div class="form-group{{ $errors->has('celr') ? ' has-error' : '' }}">
                            <label for="celr" class="col-md-4 control-label">Celular Representante: </label>
                            <label for="nombree" class="col-md-4 control-label"></label><br>

                        </div>

                        <div class="form-group{{ $errors->has('emailr') ? ' has-error' : '' }}">
                            <label for="emailr" class="col-md-4 control-label">Dirección email del Representante:</label>
                            <label for="nombree" class="col-md-4 control-label"></label><br>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
