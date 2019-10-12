@extends('layouts.app')

@section('migasdepan')
<h1>
        Pagos
        <small>Control de pagos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/pagos') }}"><i class="fa fa-dashboard"></i> Pagos</a></li>
        <li class="active">Listado de pagos</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <a href="{{ url('/pagos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>Id</th>
                  <th>Tipo de pago</th>
                  <th>Monto</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($pagos as $pago)
                  <tr>
                    <td>{{ $pago->id }}</td>
                    <td>{{ $pago->tipopago->nombre }}</td>
                    <td>{{ $pago->monto }}</td>

                    <td>
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                <a href="{{ url('pagos/'.$pago->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a href="{{ url('/pagos/'.$pago->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                                <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$pago->id.",'pagos')" }}><span class="glyphicon glyphicon-trash"></span></button>
                                {{ Form::close()}}

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