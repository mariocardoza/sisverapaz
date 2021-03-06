@extends('layouts.app')

@section('migasdepan')
<h1>
  Rubros
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
  <li class="active">Listado de Rubros</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Listado</h3>
        <div class="btn-group pull-right">
          <a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
          <a href="{{ url('/rubros?estado=1') }}" class="btn btn-primary">Activos</a>
        <a href="{{ url('/rubros?estado=2') }}" class="btn btn-primary">Papelera</a>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table class="table table-striped table-bordered table-hover" id="example2">
        <thead>
          <th>Id</th>
          <th>Nombre Rubro</th>
          <th>Porcentaje</th>
          <th>Estado</th>
          <th>Accion</th>
        </thead>
        <tbody>
            @foreach($rubros as $key => $rubro)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $rubro->nombre }}</td>
              <td>{{ $rubro->porcentaje*100 }}%</td>
              <td>{{ $rubro->estado }}</td>
              <td>
                @if($rubro->estado == 1)
                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                <a href="javascript:(0)" id="edit" data-id="{{ $rubro->id }}" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></a>
                <button class="btn btn-danger btn-sm" type="button" onclick={{ "baja(".$rubro->id.",'rubros')" }}><span class="glyphicon glyphicon-trash"></span></button>
                {{ Form::close()}}
                @else
                {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                <button class="btn btn-success" type="button" onclick={{ "alta(".$rubro->id.",'rubros')" }}><span class="fa fa-refresh btn-sm"></span></button>
                {{ Form::close()}}
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="pull-right"></div>
      </div>
    </div>
  </div>
</div>

@include("rubros.modales")
@endsection

@section("scripts")
<script>
  $(document).ready(function(e){
    $(document).on("click", "#btnmodalagregar",
      function(e){
        $("#modal_registrar").modal("show");
      });

    $(document).on("click", "#btnguardar", function(e){
      e.preventDefault();
      var datos = $("#form_rubro").serialize();
      modal_cargando();
      $.ajax({
        url:"rubros",
        type:"post",
        data:datos,
        success:function(retorno){
          if(retorno[0] == 1){
            toastr.success("Registrado con éxito");
            $("#modal_registrar").modal("hide");
            window.location.reload();
          }
          else{
            toastr.error("Falló");
            swal.closeModal();
          }
        },
        error:function(error){
          console.log();
          $(error.responseJSON.errors).each(
            function(index,valor){
              toastr.error(valor.nombre);
            });
          swal.closeModal();
        }
      });
    });

    $(document).on("click", "#edit", function(){
      var id = $(this).attr("data-id");
      $.ajax({
        url:"rubros/"+id+"/edit",
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
      modal_cargando();
      $.ajax({
        url: "/rubros"+id,
        type: "put",
        data: {nombre},
        success: function(retorno){
          if(retorno[0] == 1){
            toastr.success("Exitoso");
            $("#modal_editar").modal("hide");
            window.location.reload();
          }
          else{
            toastr.error("error");
            swal.closeModal();
          }
        },
        error:function(error){
          console.log();
          $(error.responseJSON.errors)each(function(index,valor){
            toastr.error(valor.nombre);
          });
          swal.closeModal();
        }
      });
    });
    $(document).on();
  });
</script>

@endsection