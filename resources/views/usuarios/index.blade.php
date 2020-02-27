@extends('layouts.app')

@section('migasdepan')
<h1>
        Usuarios
        <small>Control de Usuarios</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de Usuarios</li>
      </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"></h3>
                  <div class="btn-group pull-right">
                    <a href="{{ url('/usuarios/create') }}" class="btn btn-success">Agregar <span class="glyphicon glyphicon-plus-sign"></span></a>
                    <a href="{{ url('/usuarios?estado=1') }}" class="btn btn-primary">Activos</a>
                    <a href="{{ url('/usuarios?estado=2') }}" class="btn btn-primary">Papelera</a>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-bordered table-striped" id="example2">
      				<thead>
                      <th>N°</th>
                      <th>Nombre completo</th>
                      <th>Nombre de Usuario</th>
                      <th>Correo electrónico</th>
                      <th>Rol</th>
                      <th>Unidad administrativa</th>
                      <th>Acción</th>
                    </thead>
                    <tbody>
                    	@foreach($usuarios as $key => $user)
                    	<tr>
                    		<td>{{ $key+1 }}</td>
                    		<td>{{ $user->empleado->nombre }}</td>
                    		<td>{{ $user->username }}</td>
                    		<td>{{ $user->email }}</td>
                        <td>{{ $user->roleuser->role->description }}</td>
                        <td>{{ $user->unidad->nombre_unidad }}</td>
                    		<td>
                          @if($user->estado == 1 )
                              {{ Form::open(['method' => 'POST',  'class' => 'form-horizontal'])}}          
                                <a href="{{ url('usuarios/'.$user->id.'/edit') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                <button class="btn btn-danger" type="button" onclick={{ "baja(".$user->id.",'usuarios')" }}><span class="glyphicon glyphicon-trash"></span></button>
                            {{ Form::close()}}
                          @else
                              {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal'])}}
                              <button class="btn btn-success" type="button" onclick={{ "alta(".$user->id.",'usuarios')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
