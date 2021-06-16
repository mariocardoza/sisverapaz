@extends('layouts.app')
@section('migasdepan')
  <h1>
    Planilla por Proyecto
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">Control de Planilla</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <p></p>
        <div class="box-header">
          <p></p>
        </div>

        <div class="box-body table-responsive">
          <table class="table table-striped table-bordered table-hover" id="example2">
            <thead>
                <th>N°</th>
                <th>Proyecto</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acción</th>
            </thead>
            <tbody>
              @foreach ($catorcenas as $index => $c)
                  <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$c->proyecto->nombre}}</td>
                    <td>{{$c->fecha_fin->format("d/m/Y")}}</td>
                    <td>{!! \App\PeriodoProyecto::estado($c->id) !!}</td>
                    <td>
                        @if($c->estado==3)
                            <button class="btn btn-info" id="desembolso" data-id="{{$c->id}}" title="Efectuar el desembolso"><i class="fa fa-money"></i></button>
                            <a href="{{url('reportesuaci/planillaproyecto/'.$c->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a>
                        @else
                            <a href="{{url('pagocuentas/'.$c->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                        @endif
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
          <div class="pull-right">

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
$(document).ready(function(e){
    //desembolso
    $(document).on("click","#desembolso",function(e){
        var id=$(this).attr("data-id");
        modal_cargando();
        $.ajax({
            url:'planillaproyectos/desembolso/'+id,
            type:'GET',
            success: function(json){
                if(json[0]==1){
                  swal.closeModal();
                    toastr.success("Desembolso realizado");
                    location.reload();
                }else if(json[0]==-2){
                  toastr.info(json[2]);
                  swal.closeModal();
                  
                }else{
                  toastr.error("Ocurrió un error");
                  swal.closeModal();
                }
            },
            error: function(error){
                swal.closeModal();
            }
        });
    });
});
</script>
@endsection
