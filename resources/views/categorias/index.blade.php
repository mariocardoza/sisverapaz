@extends('layouts.app')

@section('migasdepan')
<h1>
        Categorías
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de categorías</li>
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
                  <a href="{{ url('/categorias?estado=1') }}" class="btn btn-primary">Activos</a>
                  <a href="{{ url('/categorias?estado=0') }}" class="btn btn-primary">Papelera</a>
                </div>
            </div>
            <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
              <tr>
                <th>N°</th>
							<th>Nombre categoría</th>
							<th>Acción</th>
              </tr>
					</thead>
					<tbody>
						@foreach($categorias as $key => $categoria)
						<tr>
              <td>{{ $key+1}}</td>
							<td>{{ $categoria->nombre_categoria}}</td>
              <td>
                  @if($categoria->estado == 1 )
                    <a href="javascript:(0)" id="edit" data-id="{{$categoria->id}}" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></a>
                    <button class="btn btn-danger btn-sm" type="button" id="baja" data-id="{{$categoria->id}}"><span class="glyphicon glyphicon-trash"></span></button>
                @else
                    <button class="btn btn-success btn-sm" type="button" id="alta" data-id="{{$categoria->id}}"><span class="glyphicon glyphicon-trash"></span></button>
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

@include("categorias.modales")
@endsection

@section("scripts")
<script type="text/javascript">
  $(document).ready(function(e){
    $(document).on("click", "#btnmodalagregar",function(e){
        $("#md_categoria").modal("show");
      });

    $(document).on("click", "#registrar_categoria", function(e){
      modal_cargando();
      e.preventDefault();
      var datos = $("#form_categoria").serialize();
      $.ajax({
        url:"categorias",
        type:"post",
        data:datos,
        success:function(json){
          console.log(json);
          if(json.mensaje=='exito'){
            toastr.success("Registrado con éxito");
            $("#md_categoria").modal("hide");
            window.location.reload();
            swal.closeModal();
          }
          else{
            toastr.error("Falló");
            swal.closeModal();
          }
        },
        error:function(error){
          swal.closeModal();
          $(error.responseJSON.errors).each(function(index,valor){
            toastr.error(valor.nombre_categoria);
          });
        }
      });
    });

    $(document).on("click", "#edit", function(e){
      e.preventDefault();
      var id = $(this).attr("data-id");
      $.ajax({
        url:"categorias/"+id+"/edit",
        type:"get",
        data:{},
        success:function(retorno){
          if(retorno[0] == 1){
            $("#modal_editar").modal("show");
            $("#e_nombre").val(retorno[2].nombre_categoria);
            $("#elid").val(retorno[2].id);
          }
          else{
            toastr.error("error");
          }
        }
      });
    });// Fin modal editar

    $(document).on("click", "#btneditar", function(e){
      var id = $("#elid").val();
      var nombre_categoria = $("#e_nombre").val();

      $.ajax({
        url:"categorias/"+id,
        type:"put",
        data:{nombre_categoria},
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

    $(document).on("click","#baja",function(e){
      e.preventDefault();
      var id = $(this).attr("data-id");
      swal({
        title:'Motivo por el que da de baja',
        input:'text',
        showCancelButton:true,
        confirmButtonText:'Dar de baja',
        showLoaderOnConfirm:true,
        preConfirm:(text) => {
          return new Promise((resolve) => {
            setTimeout(()=> {
              if(text == ""){
                swal.showValidationError(
                  'El motivo es requerido'
                )
              }
              resolve()
            }, 2000)
          })
        },
        allowOutsideClick: () => !swal.isLoading
      }).then((result) => {
        if(result.value){
          var motivo = result.value;
          $.ajax({
            url:'categorias/baja/'+id,
            type:'post',
            dataType:'json',
            data:{motivo},
            success:function(json){
              if(json[0] == 1){
                toastr.success("Registro dado de baja");
                location.reload();
              } else{
                if(json[0] == 2){
                  toastr.info(json[1]);
                } else{
                  toastr.error("Ocurrió un error");
                }
              }
            }, error:function(error){
              toastr.error("Ocurrió un error");
            }
          });
        }
      });
    });

    $(document).on("click","#alta",function(e){
      e.preventDefault();
      var id = $(this).attr("data-id");
      swal({
        title:"Categoría",
        text:"¿Desea restaurar esta Categoría?",
        type:'warning',
        showCancelButton:true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor:'#d33',
        confirmButtonText:'¡Si!',
        cancelButtonText:'¡No!',
        confirmButtonClass:'btn btn-success',
        cancelButtonClass:'btn btn-danger',
        buttonsStyling:false,
        reverseButtons:true,
      }).then((result) => {
        if(result.value){
          modal_cargando();
          $.ajax({
            url:'categorias/alta/'+id,
            type:'post',
            dataType:'json',
            success:function(json){
              if(json[0] == 1){
                toastr.success("Categoría restaurada");
                location.reload();
              } else{
                toastr.error("Ocurrió un error");
                swal.closeModal();
              }
            }, error:function(error){
              toastr.error("Ocurrió un error");
              swal.closeModal();
            }
          });
          swal(
            '¡Éxito!',
            'success'
            );
        } else if(result.dismiss == swal.DismissReason.cancel){
          swal(
            'Nueva revisión',
            'info'
            );
        }
      });
    });

    $(document).on();
  });
</script>
@endsection