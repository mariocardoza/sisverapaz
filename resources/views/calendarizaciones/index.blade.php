@extends('layouts.app')

@section('migasdepan')
<h1>
        Eventos
        <small>Control de eventos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/calendarizaciones') }}"><i class="fa fa-dashboard"></i> Calendarización</a></li>
        <li class="active">Listado de eventos</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="btn-group pull-right">
                <a href="{{ url('/calendarizaciones/create') }}" class="btn btn-success"><span class="fa fa-plus-circle"></span></a>
              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>Id</th>
                  <th>Evento</th>
                  <th>Descripción</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($calendarizaciones as $calendarizacion)
                  <tr>
                    <td>{{ $celendarizacion->id }}</td>
                    <td>{{ $calendarizacion->evento }}</td>
                    <td>{{ $calendarizacion->descripcion }}</td>
                    <td>
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                <div>
                                  <a href="{{ url('calendarizaciones/'.$calendarizacion->id) }}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                                  <a href="{{ url('/calendarizaciones/'.$calendarizacion->id.'/edit') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                  <button class="btn btn-danger" type="button" onclick={{ "baja(".$calendarizacion->id.",'calendarizaciones')" }}><span class="fa fa-trash"></span></button>
                                </div>
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
