@extends('layouts.app')

@section('migasdepan')
<h1>
        Recibos de inmuebles
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado</li>
      </ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"></h3>
        <div class="btn-group pull-right">
          <a href="{{ url('/pagos?estado=1') }}" class="btn btn-primary">Activos</a>
          <a href="{{ url('/pagos?estado=0') }}" class="btn btn-primary">Papelera</a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
            <th>N°</th>
            <th>Propietario</th>
            <th>N° Catastral/Inmueble</th>
            <th>Periodo</th>
            <th>Fecha de vencimiento</th>
            <th>Pago</th>
            <th>Estado</th>
          </thead>
          <tbody>
            @foreach($facturas as $i => $f)
            <tr>
              <td>{{ $i+1}}</td>
              <td>{{$f->inmueble->contribuyente->nombre}}</td>
              <td>{{ $f->inmueble->numero_catastral }}</td>
              <td>{{ $f->mesYear }}</td>
              <td>{{$f->fechaVecimiento->format("d/m/Y")}}</td>
              <td class="text-right">${{number_format($f->pagoTotal,2)}}</td>
              <td>
                @if($f->fechaVecimiento < date("Y-m-d") && $f->estado==1)
                <label for="" class="label-danger col-xs-12">Vencida</label>
                @elseif($f->fechaVecimiento < date("Y-m-d") && $f->estado==3) 
                <label for="" class="label-success col-xs-12">Pagado</label>
                @elseif($f->fechaVecimiento >= date("Y-m-d") && $f->estado==1)
                <label for="" class="label-primary col-xs-12">Pendiente</label>
                @elseif($f->estado==3)
                <label for="" class="label-success col-xs-12">Pagada</label>
                @elseif($f->estado==3)
                <label for="" class="label-danger col-xs-12">Anulada</label>
                @endif
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

@include("pagos.modales")

@section("scripts")
<script>
  $(document).ready(function(e){
    $(document).on("click", "#btnmodalagregar",
    function(e){
      $("#modal_registrar").modal("show");
    });

    $(document).on("click", "#btnguardar", function(e){
      e.preventDefault();
      var datos = $("#form_pago").serialize();
      $.ajax({
        url:"pagos",
        type:"post",
        data:datos,
        success:function(retorno){
          if(retorno[0] == 1){
            toastr.success("Registrado con éxito ");
            $("#modal_registrar").modal("hide");
            window.location.reload();
          }
          else{
          toastr.error("Falló");
          }
        },
        error:function(error){
          console.log();
          $(error.responseJSON.errors).each(function(index,valor){
            toastr.error(valor.nombre);
          })
        }
      });
    });

    $(document).on("click", "#edit", function(){
      var id = $(this).attr("data-id");
      $.ajax({
        url:"pagos/"+id+"/edit",
        type:"get",
        data:{},
        success:function(retorno){
          if(retorno[0] == 1){
            $("#modal_editar").modal("show");
            $("#e_nombre").val(retorno[2].nombre);
            $("#elid").val(retorno[2].id);
          }
          else{
            toastr.error("error");
          }
        }
      });
    });

    $(document).on("click", "#btneditar", function(e){
      var id = $("#elid").val();
      var nombre = $("#e_nombre").val();

      $.ajax({
        url:"pagos/"+id,
        type:"put",
        data:{nombre},
        success:function(retorno){
          if(retorno[0] == 1){
            toastr.success("Exitoso");
            $("#modal_editar").modal("hide");
            window.location.reload();
          }
          else{
            toastr.error("error");
          }
        }
      });
    });
  });
</script>
@endsection