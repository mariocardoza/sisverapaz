@extends('layouts.app')

@section('migasdepan')
<h1>
        Formas de pago
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/formapagos') }}"><i class="fa fa-dashboard"></i> Formas de pago</a></li>
        <li class="active">Listado de formas de pago</li>
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
                  <a href="jafascript: void(0)" id="btnmodalagregar" class="btn btn-success"><span class="fa fa-plus-circle"></span></a>
                  <a href="{{ url('/formapagos?estado=1') }}" class="btn btn-primary">Activos</a>
                  <a href="{{ url('/formapagos?estado=2') }}" class="btn btn-primary">Papelera</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>Id</th>
                  <th>Nombre forma de pago</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($formapagos as $formapago)
                  <tr>
                    <td>{{ $formapago->id }}</td>
                    <td>{{ $formapago->nombre }}</td>
                    <td>{{ $formapago->estado }}</td>
                    <td>
                            @if($estado == 1 || $estado == "")
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                <div class="btn-group">
                                  <a href="{{ url('/formapagos/'.$formapago->id.'/edit') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                  <button class="btn btn-danger" type="button" onclick={{ "baja(".$formapago->id.",'formapagos')" }}><span class="fa fa-thumbs-o-down"></span></button>
                                </div>
                                {{ Form::close()}}
                            @else
                                {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                                <button class="btn btn-success" type="button" onclick={{ "alta(".$formapago->id.",'formapagos')" }}><span class="fa fa-thumbs-o-up"></span></button>
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

@include("formapagos.modales")
@endsection

@section("scripts")
<script>
  $(document).ready(function(e){
    $(document).on("click", "#btnmodalagregar", function(e){
      $("#modal_registrar").modal("show");
    });

    $(document).on("click", "#btnguardar", function(e){
      e.preventDefault();
      var datos = $("#form_formapago").serialize();
      modal_cargando();
      $.ajax({
        url:"formapagos",
        type:"post",
        data:datos,
        success:function(retorno){
          if(retorno[0] == 1){
            toastr.success("Registrado");
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
          $(error.responseJSON.errors).each(function(index,valor){
            toastr.error(valor.nombre);
          });
          swal.closeModal();
        }
      });
    });

    $(document).on("click", "#edit", function(){
      var id = $(this).attr("data-id");
      $.ajax({
        url:"formapagos/"+id+"/edit",
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
    }); // FIN EDITAR

    $(document).on("click", "#btneditar", function(e){
      var id = $("#elid").val();
      var nombre = $("#e_nombre").val();
      modal_cargando();
      $.ajax({
        url:"formapagos/"+id,
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
            swal.closeModal();
          }
        },
        error:function(error){
          console.log();
          $(error.responseJSON.errors).each(function(index,valor){
            toastr.error(valor.nombre);
          });
          swal.closeModal();
        }
      });
    }); //FIN BTN EDITAR

    $(document).on();
  });
</script>
@endsection