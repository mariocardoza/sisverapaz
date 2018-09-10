@php
  use App\Categoria;
@endphp
@extends('layouts.app')

@section('migasdepan')
<h1>
        Listado de solicitudes realizadas
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/solicitudcotizaciones') }}"><i class="fa fa-align-right"></i> Solicitudes</a></li>
        <li class="active">Listado de solicitudes</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
              <div class="btn-group pull-right">
                <a href="{{ url('solicitudcotizaciones?estado=1')}}" class="btn btn-primary">Pendientes</a>
                <a href="{{ url('solicitudcotizaciones?estado=3')}}" class="btn btn-primary">Finalizado</a>
                <a href="{{ url('solicitudcotizaciones?estado=2')}}" class="btn btn-primary">Inactivados</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Proyecto o proceso</th>
                  <th>Forma de pago</th>
                  <th>Lugar de entrega</th>
                  <th>N° de solicitud</th>
                  <th>Categoria</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($solicitudes as $key => $solicitud)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    @if($solicitud->solicitud_id)
                    <td>{{ $solicitud->presupuestosolicitud->presupuesto->proyecto->nombre}}</td>
                  @elseif ($solicitud->requisicion_id)
                    <td>{{ $solicitud->requisicion->actividad}}</td>
                  @endif
                    <td>{{ $solicitud->formapago->nombre }}</td>
                    <td>{{ $solicitud->lugar_entrega }}</td>
                    <td>{{ $solicitud->numero_solicitud }}</td>
                  @if($solicitud->solicitud_id)
                    <td>{{ Categoria::categoria_nombre($solicitud->presupuestosolicitud->categoria_id)}}</td>
                  @elseif($solicitud->requisicion_id)
                      <td>Requisicion de bienes o servicios</td>
                  @endif

                      @if($solicitud->estado== 1 )
                        <td>
                        <label for="" class="label-warning">Pendiente</label>
                      </td>
                      <td>
                        <div class="btn-group">
                          <a href="{{ url('solicitudcotizaciones/'.$solicitud->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{url('solicitudcotizaciones/'.$solicitud->id.'/edit')}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                          @if($solicitud->solicitud_id)
                          <a href="{{ url('cotizaciones/realizarcotizacion/'.$solicitud->id) }}" class="btn btn-success btn-xs"><span class="fa fa-outdent"></span></a>
                        @elseif($solicitud->requisicion_id)
                          <a href="{{ url('cotizaciones/realizarcotizacionr/'.$solicitud->id) }}" class="btn btn-success btn-xs"><span class="fa fa-outdent"></span></a>
                        @endif
                        </div>
                      </td>
                    @elseif ($solicitud->estado==2)
                        <td><label for="" class="label-danger">Inactiva</label></td>
                        <td>
                          <a href="{{ url('solicitudcotizaciones/'.$solicitud->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                        </td>
                      @elseif ($solicitud->estado==3)
                      <td><label for="" class="label-success">Pendiente de cuadro comparativo</label></td>
                      <td>
                        <a href="{{ url('solicitudcotizaciones/'.$solicitud->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                      </td>
                    @elseif($solicitud->estado==4)
                      <td><label for="" class="label-success">Finalizada</label></td>
                      <td>
                        <div class="btn-group">
                          <a href="{{ url('solicitudcotizaciones/'.$solicitud->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{ url('reportesuaci/solicitud/'.$solicitud->id) }}" class="btn btn-success btn-xs" target="_blank"><span class="fa fa-file-pdf-o"></span></a>
                        </div>
                      </td>
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
</div>
@endsection
