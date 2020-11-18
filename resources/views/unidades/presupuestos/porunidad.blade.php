@extends('layouts.app')

@section('migasdepan')
<h1>
        Presupuestos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Presupuestos</li>
      </ol>
@endsection

@section('content')

<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
              <div class="btn-group col-md-10">
                  <a href="javascript:void(0)" id="abrir_registrar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                  <a href="{{ url('/presupuestounidades/porunidad?estado=1') }}" class="btn btn-primary">Activos</a>
                  <a href="{{ url('/presupuestounidades/porunidad?estado=2') }}" class="btn btn-primary">Rechazados</a>
                  <a href="{{ url('/presupuestounidades/porunidad?estado=4') }}" class="btn btn-primary">Finalizados</a>
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
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Año</th>
                  <th>Unidad</th>
                  <th>Responsable</th>
                  <th>Monto</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($presupuestos as $key => $presupuesto)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$presupuesto->anio}}</td>
                      <td>{{$presupuesto->unidad->nombre_unidad}}</td>
                      <td>{{$presupuesto->user->empleado->nombre}}</td>
                      <td>${{number_format(App\Presupuestounidad::total_presupuesto($presupuesto->id),2)}}</td>
                      <td>{!! App\Presupuestounidad::estado_ver($presupuesto->id) !!}</td>
                      <td>
                        <a href="{{url('presupuestounidades/'.$presupuesto->id)}}" title="Ver presupuesto" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                        @if($presupuesto->anio < date("Y"))
                      <button class="btn btn-success btn-sm" title="Clonar presupuesto" type="button" id="clonar" data-id="{{$presupuesto->id}}"><i class="fa fa-clone"></i></button>  
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
@include('unidades.presupuestos.modales')
@endsection
@section('scripts')
<script>
  $(document).ready(function(e){
    $(document).on("click","#abrir_registrar", function(e){
      $("#modal_registrar_presupuesto").modal("show");
    });

    //select para filtrar por año

    $(document).on("click","#btn_anio",function(e){
      var anio=$("#select_anio").val();
      if(anio > 0){
        location.href="/presupuestounidades/porunidad?anio="+anio;
      }
    });

    //clonar un presupuesto anterior
    $(document).on("click","#clonar",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      $.ajax({
        url:'/presupuestounidades/clonar/'+id,
        type:'get',
        dataType:'json',
        success: function(json){
          if(json[0]==1){
            window.location.reload();
          }
        }
      });
    });

    $(document).on("click","#registrar_presupuesto", function(e){
      e.preventDefault();
      var datos=$("#form_presupuesto").serialize();
      $.ajax({
        url:'/presupuestounidades',
        type:'POST',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Presupuesto guardado exitosamente");
            window.location.href="/presupuestounidades/"+json[2];
          }else{
            toastr.error("Ocurrió un error");
          }
        },error: function(error){
            
          }
      });
    });
  });
</script>
@endsection
