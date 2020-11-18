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
              <h3 class="box-title">Listado</h3>
              <div class="btn-group">
                <a href="javascript:void(0)" id="abrir_registrar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                <a href="{{ url('/presupuestounidades?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/presupuestounidades?estado=2') }}" class="btn btn-primary">Rechazados</a>
                <a href="{{ url('/presupuestounidades?estado=4') }}" class="btn btn-primary">Finalizados</a>
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
                      <td><a href="{{url('presupuestounidades/'.$presupuesto->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a></td>
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

    $(document).on("click","#registrar_presupuesto", function(e){
      e.preventDefault();
      var anio=0;
      anio=$("#elaniopresu").val();
      var uni=$("#uni_id").val();
      $.ajax({
        url:'/presupuestounidades/anio/'+anio,
        type:'get',
        dataType:'json',
        data:{unidad_id:uni},
        success:function(json1){
          if(json1.length > 0){
            toastr.error("Ya existe presupuesto para el año "+anio);
          }else{
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
          }
        },error: function(error){
          toastr.error('Digite un año correcto');
        }
      });
      
    });
  });
</script>
@endsection
