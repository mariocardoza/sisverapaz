@extends('layouts.app')

@section('migasdepan')
<h1>
        Categorías de fondos
        <small>Control de categorías</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/fondocats') }}"><i class="fa fa-dashboard"></i> Categorías</a></li>
        <li class="active">Listado de categorías</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <a href="{{ url('/fondocats/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                <a href="{{ url('/fondocats?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/fondocats?estado=2') }}" class="btn btn-primary">Papelera</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>Id</th>
                  <th>Categoría de Fondo</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($fondocats as $fondocat)
                  <tr>
                    <td>{{ $fondocat->id }}</td>
                    <td>{{ $fondocat->categoria }}</td>
                    <td>

                      @if($fondocat->estado == 1)
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                <a href="{{ url('fondocats/'.$fondocat->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a href="{{ url('/fondocats/'.$fondocat->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                                <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$fondocat->id.",'fondocats')" }}><span class="glyphicon glyphicon-trash"></span></button>
                                {{ Form::close()}}
                            @else
                                {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                                <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$fondocat->id.",'fondocats')" }}><span class="glyphicon glyphicon-trash"></span></button>
                                {{ Form::close()}}
                             @endif
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