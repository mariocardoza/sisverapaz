@extends('layouts.app')
@section('migasdepan')
<h1>
        Lámparas reparadas
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de lámparas reparadas</li>
      </ol>
@endsection
@section('content')
<div class="row">
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
                <div class="btn-group pull-right">
   
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Nombre de quién reportó</th>
                  <th>Detalle</th>
                  <th>Dirección</th>
                  <th>Fecha reparación</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($alumbrados as $key => $a)
                  <tr>
                    <td>{{ $key+1}}</td>
                    <td>{{ $a->reporto}}</td>
                    <td>{{ $a->detalle}}</td>
                    <td>{{ $a->direccion}}</td>
                    <td>{{ $a->fecha_reparacion->format("d/m/Y")}}</td>
                    <td>
                        <a href="{{url('alumbrado/'.$a->id)}}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
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

@section("scripts")
<script>

</script>
@endsection