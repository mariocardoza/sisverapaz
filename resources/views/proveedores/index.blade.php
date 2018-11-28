@extends('layouts.app')

@section('migasdepan')
<h1>
        Proveedores
        <small>Control de proveedores</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de proveedores</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-md-12">
          <div class="panel">
            <div class="panel-header">
              <p></p>
              	<a href="{{ url('/proveedores/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                <a href="{{ url('/proveedores?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/proveedores?estado=2') }}" class="btn btn-primary">Papelera</a>
                <a href="{{ url('proveedores/resportesuaci/proveedores')}}" class="btn btn-primary"  class="glyphicon glyphicon-list-alt">Imprimir</a>

            </div>
            <!-- /.box-header -->
            <div class="panel-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
  				<thead>
                  <th>Nombre de Proveedor</th>
                  <th>Dirección</th>
                  <th>Correo</th>
                  <th>Telefono</th>
                  <th>Número de registro</th>
                  <th>NIT</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                	@foreach($proveedores as $proveedor)
                	<tr>
                		<td>{{ $proveedor->nombre }}</td>
                		<td>{{ $proveedor->direccion }}</td>
                		<td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->numero_registro }}</td>
                        <td>{{ $proveedor->nit }}</td>
                		<td>
                            @if($estado == 1 || $estado == "")
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                <a href="{{ url('proveedores/'.$proveedor->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a href="{{ url('proveedores/'.$proveedor->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                                <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$proveedor->id.",'proveedores')" }}><span class="glyphicon glyphicon-trash"></span></button>
                                {{ Form::close()}}
                            @else
                                {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                                <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$proveedor->id.",'proveedores')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
