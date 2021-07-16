@extends('layouts.app')
@section('migasdepan')
<h1>
        Tipos de Préstamos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Tipos de Préstamo</li>
      </ol>
@endsection
@section('content')
<div class="row">
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p></p>
                <div class="btn-group pull-right">
                    <a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="fa fa-plus-circle"></span></a>
                    <a href="{{ url('/prestamotipos?estado=1') }}" id="este" class="btn btn-primary">Activos</a>
                    <a href="{{ url('/prestamotipos?estado=0') }}" class="btn btn-primary">Papelera</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Nombre</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($tipos as $key => $tipo)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $tipo->nombre}}</td>
                    <td>
                      @if($tipo->estado == 1 || $estado == "")
                        {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                        <div class="btn-group">
                          <a href="javascript:void(0)" id="edit" data-id="{{$tipo->id}}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                        <button class="btn btn-danger" type="button" onclick={{ "baja('".$tipo->id."','prestamotipos')" }}><span class="fa fa-thumbs-o-down"></span></button>
                        </div>
                        {{ Form::close()}}
                      @else
                        {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                          <button class="btn btn-success" type="button" onclick={{ "alta(".$tipo->id.",'pretamotipos')" }}><span class="fa fa-thumbs-o-up"></span></button>
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

@include("prestamotipos.modales")
@endsection

@section("scripts")
<script>
  $(document).ready(function(e){
    $(document).on("click", "#btnmodalagregar", function(e){
      $("#modal_registrar").modal("show");
    });

    $(document).on("click", "#btnguardar", function(e){
      e.preventDefault();
      var datos=$("#form_prestamotipo").serialize();
      $.ajax({
        url:"prestamotipos",
        type:"post",
        data:datos,
        success:function(retorno){
          if(retorno[0]==1){
            toastr.success("Registrado con exito");
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
        url:"prestamotipos/"+id+"/edit",
        type:"get",
        data:{},
        success:function(retorno){
          if(retorno[0]== 1){
            $("#modal_editar").modal("show");
            $("#e_nombre").val(retorno[2].nombre);
            $("#elid").val(retorno[2].id);
          }
          else{
            toastr.error("error");
          }
        }
      });
    });    //Fin modal para editar

    $(document).on("click", "#btneditar", function(e){
      var id = $("#elid").val();
      var nombre = $("#e_nombre").val();

      $.ajax({
        url: "prestamotipos/"+id,
        type: "put",
        data: {nombre},
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
    });         //Fin de btneditar

    $(document).on()

  });
</script>
@endsection