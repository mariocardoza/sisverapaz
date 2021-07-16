@extends('layouts.app')

@section('migasdepan')
<h1>
        Presupuestos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Presupuestos</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <p></p>
            <div class="box-header">
              <p></p>
              <div class="btn-group pull-right">
                
                  <a title="Registar el presupuesto para este proyecto" href="{{ url('presupuestos/seleccionaritem/'.$proyecto) }}" class="btn btn-success"><span class="fa fa-balance-scale"></span></a>

                <a href="{{ url('/presupuestos?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/presupuestos?estado=2') }}" class="btn btn-primary">Papelera</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Año</th>
                  <th>Proyecto</th>
                  <th>Ítem</th>
                  <th>Monto</th>
                  <th>Accion</th>
                  <?php $contador=0; ?>
                </thead>
                <tbody>
                  @foreach($presupuestos as $presupuesto)
                    <tr>
                      <?php $contador++; ?>
                      <td>{{$contador}}</td>
                      <td>{{$presupuesto->created_at->format('Y')}}</td>
                      <td>{{$presupuesto->proyecto->nombre}}</td>
                      <td>{{$presupuesto->categoria->item}} {{$presupuesto->categoria->nombre_categoria}}</td>
                      <td>${{number_format($presupuesto->total,2)}}</td>
                      <td>
                        <div class="btn-group">
                          <a href="{{url('presupuestos/'.$presupuesto->id)}}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                          <a title="Agregar elementos al presupuesto" class="btn btn-success" href="{{url('presupuestodetalles/create/'.$presupuesto->id)}}"><span class="fa fa-plus-circle"></span></a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
</div>
@endsection
