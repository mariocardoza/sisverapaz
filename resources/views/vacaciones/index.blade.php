@extends('layouts.app')

@section('migasdepan')
<h1>
        Vacaciones
        @if($estado==0)
        <small>Asignación de vacaciones</small>
        @else
        <small>Asignadas</small>
        @endif
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/vacaciones') }}"><i class="fa fa-dashboard"></i> Vacaciones</a></li>
        <li class="active">Listado de empleados con vacaciones asignadas</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
              @if($estado==0)
                <a href="{{ url('/vacaciones?estado=2') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Asignadas</a>
              @else
              <a href="{{ url('/vacaciones?estado=0') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span>Por Asignar</a>
              @endif
            </div>
            <!-- /.box-header -->
            
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Nombre empleado</th>
                  <th>Inicio de labores</th>
                  @if($estado==0)
                    <th>Acción</th>
                  @else
                  <th>Fecha del pago</th>
                  <th>Pago</th>
                  @endif
                  
                </thead>
                <tbody>
                  @foreach($vacaciones as $index => $vacacion)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $vacacion->detalleplanilla->empleado->nombre }}</td>
                    <td>{{ $vacacion->detalleplanilla->fecha_inicio->format('d-m-Y') }}</td>
                    @if($estado==0)
                      @php
                          $pago=App\detalleplanilla::pago($vacacion->detalleplanilla->id);
                      @endphp
                      <td><button type="button" data-id="{{$vacacion->id}}" data-pago="{{number_format($pago,2)}}" class="btn btn-primary" name="button" id="btn_vacacion"><span class="glyphicon glyphicon-ok"></span></button></td>
                    @else
                    <td>{{ $vacacion->fecha_pago }}</td>
                    <td>{{ number_format($vacacion->pago,2) }}</td>
                    @endif
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
