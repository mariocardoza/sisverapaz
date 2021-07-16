@extends('layouts.app')

@section('migasdepan')
<h1>
    Puestos a perpetuidad
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">Nuevo</li>
  </ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header">
        <p></p>
        <div class="pull-right">
            <p></p>
            <a href="{{url("perpetuidad/create")}}" class="btn btn-success"><i class="fa fa-plus-circle"></i></a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Contribuyente</th>
                            <th>Cementerio</th>
                            <th>Fecha </th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($titulos as $index =>$t)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$t->Contribuyente->nombre}}</td>
                                <td>{{$t->cementerio->nombre}}</td>
                                <td>{{$t->created_at->diffforhumans(null, false, false, 3)}}</td>
                                <td><a href="{{url('perpetuidad/'.$t->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    
</script>
@endsection