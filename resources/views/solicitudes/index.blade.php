@extends('layouts.app')

@section('migasdepan')
<h1>
	Solicitudes de bienes o servicios
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
	<li class="active">Listado de solicitudes</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="box-title"><h4>Solicitudes</h4></div>
            </div>
            <div class="box-body table-responsive">
                <table class="table" id="example2">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Cuenta</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudes as $i=> $c)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$c->cuenta->nombre}}</td>
                                <td>{{$c->estado}}</td>
                                <td>
                                    <a href="{{url('solicitudes/'.$c->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection