@extends('layouts.app')

@section('migasdepan')
<h1>
        Especialistas
        <small>Control de especialistas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de especialistas</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p></p>
              <div class="btn-group pull-right">
              	<a href="{{ url('/especialistas/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                <a href="{{ url('/especialistas') }}" class="btn btn-primary">Todos</a>
                <a href="{{ url('/especialistas?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/especialistas?estado=2') }}" class="btn btn-primary">Papelera</a>

                <!--ME QUEDÉ AQUIIIII-->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="panel-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
  				<thead>
                  <th>Especialista</th>
                  <th>Dirección</th>
                  <th>Correo</th>
                  <th>Teléfono</th>
                  <th>DUI</th>
                  <th>NIT</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                	@foreach($especialistas as $especialista)
                	<tr>
                		<td>{{ $especialista->nombre }}</td>
                		<td>{{ $especialista->direccion }}</td>
                		<td>{{ $especialista->email }}</td>
                    <td>{{ $especialista->telefono_fijo }}</td>
                    <td>{{ $especialista->dui }}</td>
                    <td>{{ $especialista->nit }}</td>
                		<td>
                            @if($especialista->estado == 1)
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                <a href="{{ url('especialistas/'.$especialista->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a href="{{ url('especialistas/'.$especialista->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                                <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$especialista->id.",'especialistas')" }}><span class="glyphicon glyphicon-trash"></span></button>
                                {{ Form::close()}}
                            @else
                                {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                                <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$especialista->id.",'especialistas')" }}><span class="glyphicon glyphicon-trash"></span></button>
                                {{ Form::close()}}
                             @endif
                        </td>
                	</tr>
                	@endforeach
                </tbody>
              </table>

            </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->
        </div>
</div>
@endsection
