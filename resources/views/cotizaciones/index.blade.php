@extends('layouts.app')

@section('migasdepan')
<h1>
        Cotizaciones
        <small>Control de cotizaciones</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Listado de cotizaciones</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p></p>
              <div class="btn-group pull-right">
                <a href="{{ url('/solicitudcotizaciones/versolicitudes') }}" class="btn btn-danger" title="Atras"><span class="glyphicon glyphicon-menu-left"></span></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Nombre del proyecto o actividad</th>
                  <th>Proveedor</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($cotizaciones as $key => $cotizacion)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    @if($cotizacion->solicitudcotizacion->tipo==1)
                    <td>{{ $cotizacion->solicitudcotizacion->presupuestosolicitud->presupuesto->proyecto->nombre }}</td>
                  @elseif($cotizacion->solicitudcotizacion->tipo==2)
                    <td>{{ $cotizacion->solicitudcotizacion->requisicion->actividad }}</td>
                  @endif
                    <td>{{ $cotizacion->proveedor->nombre }}</td>
                    <td>{{ $cotizacion->descripcion }}</td>
                    <td>
                            @if($estado == "")
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                  <div class="btn-group">
                                    <a href="{{ url('cotizaciones/'.$cotizacion->id) }}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                                    <a href="{{ url('cotizaciones/'.$cotizacion->id.'/edit') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                    <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$cotizacion->id.",'cotizaciones')" }}><span class="fa fa-thumbs-o-down"></span></button>
                                  </div>
                                {{ Form::close()}}
                            @endif
                            @if($estado == 1)
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                  <div class="btn-group">
                                    <a href="{{ url('cotizaciones/'.$cotizacion->id) }}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                                    <a href="{{ url('cotizaciones/'.$cotizacion->id.'/edit') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                    <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$cotizacion->id.",'cotizaciones')" }}><span class="fa fa-thumbs-o-down"></span></button>
                                  </div>
                                {{ Form::close()}}
                            @endif
                            @if($estado==2)
                                {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                                <button class="btn btn-success" type="button" onclick={{ "alta(".$cotizacion->id.",'cotizaciones')" }}><span class="fa fa-thumbs-o-up"></span></button>
                                {{ Form::close()}}
                             @endif
                             @if($estado == 3)
                                 {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                   <div class="btn-group">
                                     <a href="{{ url('cotizaciones/'.$cotizacion->id) }}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                                     <a href="{{ url('cotizaciones/'.$cotizacion->id.'/edit') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                     <button class="btn btn-danger" type="button" onclick={{ "baja(".$cotizacion->id.",'cotizaciones')" }}><span class="fa fa-thumbs-o-down"></span></button>
                                   </div>
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
