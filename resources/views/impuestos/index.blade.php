@extends('layouts.app')

@section('migasdepan')
    <h1>
        <small>Tipo de servicios</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('impuestos') }}"><i class="fa fa-dashboard"></i> Listado de Servicios municipales</a></li>
        <li class="active">Listado de servicios</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <p></p>
                    <a href="{{ url('/impuestos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="example2">
                        <thead>
                        <th>Id</th>
                        <th>Nombre del servicio municipal</th>
                        <th>Impuesto</th>
                        <th>Accion</th>
                        </thead>
                        <tbody>
                        @foreach($impuestos as $impuesto)
                            <tr>
                                <td>{{ $impuesto->id }}</td>
                                <td>{{ $impuesto->tiposervicio->nombre }}</td>
                                <td>$ {{ $impuesto->impuesto }}</td>
                                <td>
                                    {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                    <div class="btn-group">
                                        <a href="{{ url('impuestos/'.$impuesto->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                                        <a href="{{ url('/impuestos/'.$impuesto->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                                    </div>
                                    {{ Form::close()}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                    <div class="pull-right">

                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
