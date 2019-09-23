@extends('layouts.app')

@section('migasdepan')
<h1>
        Empleados
        <small>Control de empleados</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/empleados') }}"><i class="fa fa-dashboard"></i> Empleados</a></li>
        <li class="active">Listado de empleados</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <a href="{{ url('/empleados/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                <a href="{{ url('/empleados?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/empleados?estado=2') }}" class="btn btn-primary">Papelera</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Nombre empleado</th>
                  <th>DUI</th>
                  <th>Celular</th>
                  <th>Dirección</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($empleados as $index => $empleado)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->dui }}</td>
                    <td>{{ $empleado->celular }}</td>
                    <td>{{ $empleado->direccion }}</td>
                    
                    <td>
                      @if($estado == 1 || $estado == "")
                        {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                          <a href="{{ url('empleados/'.$empleado->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                          @if($empleado->estado == 1)
                          <a href="{{ url('empleados/'.$empleado->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>

                          <!--a title="" href="{{ url('categoriaempleados/create?empleado='.$empleado->id) }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-list-alt"></span></a-->

                          @elseif($empleado->estado == 2)
                          <a title="" href="{{ url('categoriaempleados/create?empleado='.$empleado->id) }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-list-alt"></span></a>

                          <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$empleado->id.",'empleados')" }}><span class="glyphicon glyphicon-trash"></span></button>

                          @endif

                        {{ Form::close()}}
                      @else
                        {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                          <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$empleado->id.",'empleados')" }}><span class="glyphicon glyphicon-trash"></span></button>
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