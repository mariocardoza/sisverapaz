@extends('layouts.app')

@section('migasdepan')
    <h1><small>Tipo de servicios</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/tiposervicios') }}"><i class="fa fa-dashboard"></i> Tipos de Servicio</a></li>
        <li class="active">Listado de servicios</li>
    </ol>
@endsection

@section('content')
    <div class="container-full">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Listado</h3>
                        <a href="{{ url('/tiposervicios/create') }}" class="btn btn-success pull-right">
                            <span class="glyphicon glyphicon-plus-sign"></span> Agregar
                        </a>
                    </div>
                    <div class="box-body">
                        <div class="">
                            <table class="table table-striped table-bordered table-hover" id="example2">
                                <thead>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Costo</th>
                                    <th>Estado</th>
                                    <th>Es Obligatorio</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($tipoServicio as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->costo }} $ </td>
                                            <td>{{ $item->estado }}</td>
                                            <td>{{ $item->isObligatorio }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
