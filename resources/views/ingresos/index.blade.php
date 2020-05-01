@extends('layouts.app')

@section('migasdepan')
<h1>
        Ingresos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/ingresos') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Ingresos totales</li>
      </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Listado</h3>
              
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered table-hover" id="example2">
        <thead>
                <th>N°</th>
                <th>Cuenta</th>
                <th>Detalle</th>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Fiestas</th>
                <th>Fecha</th>
                <th>Acción</th>
              </thead>
              <tbody>
                @foreach($ingresos as $index => $ingreso)
                <tr>
                  <td>{{ $index+1 }}</td>
                  
                  <td>{{ $ingreso->cuenta->nombre }}</td>
                  <td>{{ $ingreso->detalle }}</td>
                  <td>{{$ingreso->tipo}}</td>
                  <td class="text-right">${{ number_format($ingreso->monto,2) }}</td>
                  <td class="text-right">${{ number_format($ingreso->fiestas,2) }}</td>
                   
                  <td>{{ $ingreso->fecha->format('d/m/Y') }}</td>
                  <td>
                      @if($ingreso->estado == 1) 
                          <a href="javascript:void(0)" id="realizar_pago" data-id="{{$ingreso->id}}" title="Ejecutar desembolso" class="btn btn-info"><span class="fa fa-money"></span></a>
                          
                      @else
                          <button class="btn btn-success" type="button" ><span class="fa fa-print"></span></button>
                          
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