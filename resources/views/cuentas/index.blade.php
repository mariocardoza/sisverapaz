@extends('layouts.app')

@section('migasdepan')
<h1>
  Cuentas
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/cuentas') }}"><i class="fa fa-dashboard"></i>Cuentas</a></li>
  <li class="active">Listado de cuentas</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
    <div class="box-header">
      <h3 class="box-tittle">Listado</h3>
      <a href="{{ url('/cuentas?estado=1') }}" class="btn btn-primary">Activos</a>
      <a href="{{ url('cuentas?estado=2') }}" class="btn btn-primary">Papelera</a>
    </div>

    <div class="box-body table-responsive">
      <table class="table table-striped table-bordered table-hover" id="example2">
        <thead>
          <!--th>Nombre</th-->
          <th>Monto</th>
          <th>Número de cuenta</th>
          <th>Banco</th>
          <th>Acción</th>
          <?php $contador = 0 ?>
        </thead>
      <tbody>
        @foreach($cuentas as $cuenta)
        <tr>
          <?php $contador++ ?>
          <!--td>{{ $cuenta->nombre }}</td-->
          <td>{{ $cuenta->monto_inicial }}</td>
          <td>{{ $cuenta->numero_cuenta }}</td>
          <td>{{ $cuenta->banco }}</td>
          
          <td>
            @if($cuenta->estado == 1)
            {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
            <a href="{{ url('cuentas/'.$cuenta->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
            <a href="{{ url('cuentas/'.$cuenta->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
            <a href="{{ url('cuentas/'.$cuenta->id.'/reasigna') }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-retweet"></span></a>

            <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$cuenta->id.",'cuentas')" }}><span class="glyphicon glyphicon-trash"></span></button>
            {{ Form::close()}}
            @else
            {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
            <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$cuenta->id.",'cuentas')" }}><span class="glyphicon glyphicon-trash"></span></button>
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