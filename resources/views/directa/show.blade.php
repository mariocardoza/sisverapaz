@extends('layouts.app')

@section('migasdepan')
<h1>
        Compras directas
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{ url('/directa') }}"><i class="fa fa-home"></i> Compras</a></li>
        <li class="active">Compra</li>
      </ol>
@endsection

@section('content')
<style>
  .subir{
      padding: 5px 10px;
      background: #f55d3e;
      color:#fff;
      border:0px solid #fff;
  }
  
  .skin-blue{
    padding-right: 0px !important;
  }
   
  .subir:hover{
      color:#fff;
      background: #f7cb15;
  }
  </style>
<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-primary">
            <div class="panel-heading">Detalle</div>
            <div class="panel-body">
              <button class="btn btn-primary agregar" type="button">Agregar</button>
              <table class="table">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Archivo</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($compra->detalle as $i=>$d)
                    <tr>
                      <td>{{$i+1}}</td>
                      <td>{{$d->nombre}}</td>
                      <td>{{$d->archivo}}</td>
                      <td>
                        <a href="{{'../directa/bajar/'.$d->archivo}}" class="btn btn-primary" target="_blank"><i class="fa fa-download"></i></a>
                        <a data-archivo="{{$d->archivo}}" data-id="{{$d->id}}" href="javascript:void(0)" class="btn btn-danger quitar"><i class="fa fa-remove"></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Compra</div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <span style="font-weight: normal;">Código:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>{{$compra->codigo}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">

                  <div class="col-sm-12">
                    <span style="font-weight: normal;">Número del proceso:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>{{$compra->numero_proceso}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">

                  <div class="col-sm-12">
                    <span style="font-weight: normal;">Nombre:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>{{$compra->nombre}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">

                  <div class="col-sm-12">
                    <span style="font-weight: normal;">Monto:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>${{ number_format($compra->monto,2)}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">

                  <div class="col-sm-12">
                    <span style="font-weight: normal;">Declaratoria de emergencia:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>{{ $compra->emergencia->numero_acuerdo}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">

                  <div class="col-sm-12">
                    <span style="font-weight: normal;">Motivo de la emergencia:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>{{ $compra->emergencia->detalle}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">
                  <br>
                  <a href="javascript:void(0)" class="btn btn-warning editar" data-id="{{$compra->id}}"><i class="fa fa-edit"></i></a>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_subir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Subir documento</h4>
      </div>
      <div class="modal-body">
          <form id='form_subir' enctype="multipart/form-data">
            <input type="hidden" name="contratacion_id" value="{{$compra->id}}">
            <div class="form-group">
              <label for="" class="control-label">Nombre</label>
              <div>
                <input type="text" class="form-control" name="nombre" autocomplete="off" placeholder="Nombre del contrato">
              </div>
            </div>

            <label for="file-upload" class="subir">
              <i class="glyphicon glyphicon-cloud"></i> Subir archivo
          </label>
          <input id="file-upload" onchange='cambiar()' name="archivo" type="file" style='display: none;'/>
          <div id="info"></div>
              <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit"  class="btn btn-success">Guardar</button></center>
          </form>
      </div>
      <!--div class="modal-footer">
        <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="agregar_orden" class="btn btn-success">Agregar</button></center>
      </div-->
    </div>
    </div>
</div>
<div id="modal_aqui"></div>

@endsection
@section('scripts')
<script>
$(document).ready(function(e){
  const MAXIMO_TAMANIO_BYTES = 10000000; // 1MB = 1 millón de bytes
  $(document).on("click",".agregar",function(e){
    e.preventDefault();
    $("#modal_subir").modal("show");
  });

  
  $(document).on("click",".editar",function(e){
          e.preventDefault();
          var id=$(this).attr("data-id");
          $.ajax({
            url:'../directa/modaledit/'+id,
            type:'get',
            dataType:'json',
            success: function(json){
              if(json[0]==1){
                $("#modal_aqui").empty();
                $("#modal_aqui").html(json[1]);
                $("#modal_edit").modal("show");
              }else{
                toastr.error("Ocurrió un error en el servidor");
              }
            },
            error: function(e){
              toastr.error("Ocurrió un error en el servidor");

            }
          });
        });

  //quitar archivo
  $(document).on("click",".quitar",function(e){
    e.preventDefault();
    var archivo=$(this).attr("data-archivo");
    var id=$(this).attr("data-id");
    
      swal({
          title: 'Archivo',
          text: "¿Desea eliminar este archivo?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '¡Si!',
          cancelButtonText: '¡No!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            modal_cargando();
            $.ajax({
              url:'../directa/eliminar',
              type:'delete',
              dataType:'json',
              data:{archivo,id},
              success: function(json){
                if(json[0]==1){
                  toastr.success("El archivo ha sido eliminado con éxito");
                  location.reload();
                }else{
                  swal.closeModal();
                  toastr.error("Ocurrió un error al eliminar el archivo");
                }
              },
              error: function (error){
                swal.closeModal();
                  toastr.error("Ocurrió un error al eliminar el archivo");
              }
            });
          } else if (result.dismiss === swal.DismissReason.cancel) {
            
          }
        });
  });

  $(document).on('submit','#form_subir', function(e) {
        // evito que propague el submit
        e.preventDefault();
        // agrego la data del form a formData
        var formData = new FormData(this);
        formData.append('_token', $('input[name=_token]').val());
       // if (this.formData.archivo.length <= 0) return;
        modal_cargando();

        // Validamos el primer archivo únicamente
       // if(archivo)
       var archivo=document.getElementById('file-upload').value;
      if(archivo != ''){
        var peso = document.getElementById('file-upload').files[0].size;
        if (peso > MAXIMO_TAMANIO_BYTES) {
          const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
          toastr.info('El tamaño máximo del archivo debe ser: '+tamanioEnMb+'MB');
          //alert(`El tamaño máximo es ${tamanioEnMb} MB`);
          swal.closeModal();
          // Limpiar
        } else {
          // Validación pasada. Envía el formulario o haz lo que tengas que hacer
          $.ajax({
            type:'POST',
            url:'../directa/subir',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data[0]==1){
                  toastr.success("Documento subido con exito");
                  location.reload();
                  swal.closeModal();
                }else{
                  swal.closeModal();
                }
            },
            error: function(error){
              $.each(error.responseJSON.errors, function( key, value ) {
                toastr.error(value);
                
              });
              swal.closeModal();
            }
        });
        }
      }else{
        $.ajax({
            type:'POST',
            url:'../directa/subir',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data[0]==1){
                  toastr.success("Documento subido con exito");
                  $("#modal_subir").modal("hide");
                  $("#form_subir").trigger("reset");
                  swal.closeModal();
                }else{
                  swal.closeModal();
                }
            },
            error: function(error){
              $.each(error.responseJSON.errors, function( key, value ) {
                toastr.error(value);
                
              });
              swal.closeModal();
            }
        });
      }
        
       
      });
});
function cambiar(){
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info').innerHTML = pdrs;
  }

 
</script>
@endsection