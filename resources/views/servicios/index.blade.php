@extends('layouts.app')

@section('migasdepan')
<h1>
  Servicios
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
  <li class="active">Listado de servicios</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-tittle"></h3>
        <div class="btn-group">
            <a href="javascript:void(0)" id="modal_registrar" class="btn btn-success">Registrar nuevo</a>
            <a href="{{ url('servicios?estado=1') }}" class="btn btn-primary">Actuales</a>
            <a href="{{ url('servicios?estado=2') }}" class="btn btn-primary">Cancelados</a>
        </div>
      </div>

    <div class="box-body table-responsive">
      <table class="table table-striped table-bordered table-hover" id="example2">
        <thead>
          <th>N°</th>
          <th>Nombre del servicio</th>
          <th>Fecha de contratación</th>
          <th>Acción</th>
        </thead>
        <tbody>
            @foreach ($servicios as $i => $s)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$s->nombre}}</td>
                    <td>{{$s->fecha_contrato->format("d/m/Y")}}</td>
                    <td>
                      @if($estado==1)
                      <button class="btn btn-warning editar" type="button" data-id="{{$s->id}}"><i class="fa fa-edit"></i></button>
                      <button title="Eliminar" class="btn btn-danger quitaservicio" data-id="{{$s->id}}" type="button"><i class="fa fa-remove"></i></button>
                      @else
                      <button title="Restaurar" class="btn btn-success restaurar" data-id="{{$s->id}}" type="button"><i class="fa fa-refresh"></i></button>
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
<div id="modal_aqui"></div>
@include('servicios.modales')
@endsection
@section('scripts')
<script>
$(document).ready(function(e){

    $(document).on("click","#modal_registrar",function(e){
        e.preventDefault();
        $("#modal_servicio").modal("show");
    });

    //registrar servicio
    $(document).on("click","#registrar_servicio",function(e){
        e.preventDefault();
        var datos=$("#form_servicio").serialize();
        modal_cargando();
        $.ajax({
            url:'servicios',
            type:'post',
            data:datos,
            success: function(json){
                if(json[0]==1){
                    toastr.success("Servicio registrado con éxito");
                    location.reload();
                }else{
                    swal.closeModal();
                    toastr.error("A ocurrido un error en la operación");
                }
            },
            error: function(error){
                $.each(error.responseJSON.errors, function( key, value ) {
                    toastr.error(value);
                });
                swal.closeModal(); 
            }
        });
    });

    $(document).on("click",".quitaservicio",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
        title: '¿Está seguro de realizar esta operación?',
        text: "Se cancelará el servicio",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si!',
        cancelButtonText: '¡No!',
        confirmButtonClass: 'btn btn-danger',
        cancelButtonClass: 'btn btn-default',
        buttonsStyling: false,
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          modal_cargando();
          $.ajax({
            url:'servicios/'+id,
            type:'delete',
            dataType:'json',
            success: function(json){
              if(json[0]==1){
                swal.closeModal();
                toastr.success('Servicio eliminado con éxito');
                location.reload();
              }else{
                toastr.error("Ocurrió un error");
                swal.closeModal();
              }
            }, error: function(error){
              swal.closeModal();
            }
          });
        } else if (result.dismiss === swal.DismissReason.cancel) {
          swal.closeModal();
        }
      });
    });

    $(document).on("click",".restaurar",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
        title: '¿Está seguro de realizar esta operación?',
        text: "Se restaurará el servicio",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si!',
        cancelButtonText: '¡No!',
        confirmButtonClass: 'btn btn-danger',
        cancelButtonClass: 'btn btn-default',
        buttonsStyling: false,
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          modal_cargando();
          $.ajax({
            url:'servicios/restaurar/'+id,
            type:'delete',
            dataType:'json',
            success: function(json){
              if(json[0]==1){
                toastr.success('Servicio restaurado con éxito');
                location.href='servicios';
                swal.closeModal();
              }else{
                toastr.error("Ocurrió un error");
                swal.closeModal();
              }
            }, error: function(error){
              swal.closeModal();
            }
          });
        } else if (result.dismiss === swal.DismissReason.cancel) {
          
        }
      });
    });

    //editar un servicio
    $(document).on("click",".editar",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      modal_cargando();
      $.ajax({
        url:'servicios/'+id+'/edit',
        type:'get',
        dataType:'json',
        success: function(json){
          swal.closeModal();
          if(json[0]==1){
            $("#editar_servicio").attr("data-id",json[1].id);
            $(".nom").val(json[1].nombre);
            $(".fech").val(json[2]);
            $("#modal_eservicio").modal("show");
          }
        }, error: function(error){
          swal.closeModal();
          toastr.error("Ocurrió un error");
        }
      })
    });

    //editar servicio
    $(document).on("click","#editar_servicio",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      var datos=$("#form_eservicio").serialize();
      modal_cargando();
      $.ajax({
        url:'servicios/'+id,
        type:'put',
        dataType:'json',
        data:datos,
        success: function(json){
            if(json[0]==1){
                toastr.success("Servicio editado con éxito");
                location.reload();
            }else{
                swal.closeModal();
                toastr.error("A ocurrido un error en la operación");
            }
        },
        error: function(error){
            $.each(error.responseJSON.errors, function( key, value ) {
                toastr.error(value);
            });
            swal.closeModal(); 
        }
      });
    });
});
</script>
@endsection