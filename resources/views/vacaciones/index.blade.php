@extends('layouts.app')

@section('migasdepan')
<h1>
        Vacaciones
        <small>Asignación de vacaciones</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/vacaciones') }}"><i class="fa fa-dashboard"></i> Vacaciones</a></li>
        <li class="active">Listado de empleados para asignar vacación</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                {{-- <a href="{{ url('/empleados/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                <a href="{{ url('/empleados?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/empleados?estado=2') }}" class="btn btn-primary">Papelera</a> --}}
            </div>
            <!-- /.box-header -->
            
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Nombre empleado</th>
                  <th>Inicio de labores</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($vacaciones as $index => $vacacion)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $vacacion->detalleplanilla->empleado->nombre }}</td>
                    <td>{{ $vacacion->detalleplanilla->fecha_inicio->format('d-m-Y') }}</td>
                    @php
                        $pago=App\detalleplanilla::pago($vacacion->detalleplanilla->id);
                    @endphp
                    <td><button type="button" data-id="{{$vacacion->id}}" data-pago="{{$pago}}" class="btn btn-primary" name="button" id="btn_vacacion"><span class="glyphicon glyphicon-ok"></span></button></td>
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
        @include('vacaciones.modales')
</div>
@endsection
@section('scripts')
{!! Html::script('js/vacacion.js?cod='.date('Yidisus')) !!}
@endsection
