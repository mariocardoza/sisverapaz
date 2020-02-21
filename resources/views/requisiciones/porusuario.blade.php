@extends('layouts.app')

@section('migasdepan')
<h1>
        Requisiciones
        <small>Control de requisiciones</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de requisiciones</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
              <div class="row">
                <div class="btn-group col-md-10">
                  <a href="{{ url('/requisiciones/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                </div>
                <div class="col-md-2">
                  <select name="" id="select_anio" class="chosen-select-width pull-right">
                    <option value="0">Seleccione el año</option>
                    @foreach ($anios as $anio)
                      @if($elanio==$anio->anio)
                      <option selected value="{{$anio->anio}}">{{$anio->anio}}</option>
                      @else 
                      <option value="{{$anio->anio}}">{{$anio->anio}}</option>
                      @endif
                    @endforeach
                  </select>
                  <button class="btn btn-primary" id="btn_anio">Aceptar</button>
                </div>
              </div>
          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Código</th>
                  <th>Actividad</th>
                  <th>Unidad administrativa</th>
                  <th>Fuente de financiamiento</th>
                  <th>Responsable</th>
                  <th>Observaciones</th>
                  <th>Estado</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($requisiciones as $key => $requisicion)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $requisicion->codigo_requisicion }}</td>
                    <td>{{ $requisicion->actividad }}</td>
                    <td>{{ $requisicion->user->roleuser->role->description }}</td>
                    @if(isset($requisicion->cuenta_id))
                    <td>{{ $requisicion->cuenta->nombre}}</td>
                    @else 
                    <td>Sin definir</td>
                    @endif
                    <td>{{ $requisicion->user->empleado->nombre }}</td>
                    <td>{{ $requisicion->observaciones }}</td>
                    <td>{!! \App\requisicione::estado_ver($requisicion->id) !!}</td>
                    <td>
                      <div class="btn-group">
                        <a href="{{url('requisiciones/'.$requisicion->id)}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span></a>
                      </div>
                    </td>
                  
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>
@endsection
@section('scripts')
<script>
  $(document).ready(function(e){
    $(document).on("click","#btn_anio",function(e){
      var anio=$("#select_anio").val();
      if(anio > 0){
        location.href="../requisiciones/porusuario?anio="+anio;
      }
    });
  });
</script>
@endsection
