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
                <table class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Código</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection