@extends('layouts.app')

@section('migasdepan')
<h1>
        Tipo de pagos
        <small>Control de tipos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/tipopagos') }}"><i class="fa fa-dashboard"></i> Tipos</a></li>
        <li class="active">Listado de tipos de pago</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <a href="{{ url('/tipopagos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>Id</th>
                  <th>Nombre del tipo pago</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($tipopagos as $tipopago)
                  <tr>
                    <td>{{ $tipopago->id }}</td>
                    <td>{{ $tipopago->nombre }}</td>
                    <td>
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                <a href="{{ url('tipopagos/'.$tipopago->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a href="{{ url('tipopagos/'.$tipopago->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                                <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$tipopago->id.",'tipopagos')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
