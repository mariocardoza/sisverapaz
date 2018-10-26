@extends('layouts.app')

@section('migasdepan')
<h1>
        Planilla
        <small>Detalles de planilla</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/detalleplanillas') }}"><i class="fa fa-industry"></i> Planillas</a></li>
        <li class="active">Detalles de planilla</li>
      </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
      <div class="box-header">
        <h3 class="box-tittle">Listado</h3>
        <a href="{{ url('/detalleplanillas/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span>Agregar</a>
      </div>

      <div class="box-body table-responsive">
        <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
            <th>Empleado</th>
            <th>Salario</th>
            <th>Forma de pago</th>
            <th>Tiempo de pago</th>
            <?php $contador = 0 ?>
          </thead>
        <tbody>
          @foreach($empleados as $empleado)
          <tr>
            <?php $contador++ ?>
            <td>{{ $empleado->nombre }}</td>
            <td>{{ $empleado->salario }}</td>
            <td>{{ $empleado->tipo_pago }}</td>
            <td>{{ $empleado->pago }}</td>

            <td>
              @if($empleado->estado == 1)
              {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
              <a href="{{ url('cuentas/'.$empleado->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
              <a href="{{ url('crgoss/'.$empleado->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
              <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$empleado->id.",'cuentas')" }}><span class="glyphicon glyphicon-trash"></span></button>
              {{ Form::close()}}
              @else
              {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
              <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$empleado->id.",'cuentas')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
    </div>
    </div>
  </div>
@endsection
