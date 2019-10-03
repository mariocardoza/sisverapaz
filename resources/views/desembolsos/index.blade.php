@extends('layouts.app')

@section('migasdepan')
<h1>
        Desembolsos
        <small>Movimientos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Movimientos</li>
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
                  <th>Monto</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($desembolsos as $index => $desembolso)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    @if($desembolso->cuentaproy_id)
                    <td>Proyecto: {{ $desembolso->cuentaproy->proyecto->nombre }}</td>
                    @else
                    <td>{{ $desembolso->cuenta->nombre }}</td>
                    @endif 
                    
                    <td>{{ $desembolso->detalle }}</td>
                    <td class="text-right">${{ number_format($desembolso->monto,2) }}</td>
                    <td class="">{!! \App\Desembolso::estado($desembolso->id) !!}</td>
                    <td>
                        @if($desembolso->estado == 1)
                            {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                            <a href="{{ url('/formapagos/'.$desembolso->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                            <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$desembolso->id.",'formapagos')" }}><span class="glyphicon glyphicon-trash"></span></button>
                            {{ Form::close()}}
                        @else
                            {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                            <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$desembolso->id.",'formapagos')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
