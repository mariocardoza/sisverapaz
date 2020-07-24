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
  @php
  $proveedores=[];
  $medidas=[];
  $materiales=[];
  $proveedores=App\Proveedor::whereEstado(1)->get();
  $medidas=App\UnidadMedida::get();
  $materiales=App\Materiales::whereEstado(1)->get();
@endphp
<div class="row">
    <div class="col-sm-8">
      <div class="btn-group">
        <button class="btn btn-primary que_ver" data-tipo="1" >Solicitud</button>
        @if(Auth()->user()->hasRole('uaci'))
        <button class="btn btn-primary que_ver" data-tipo="3">Documentos</button>
        @endif
        <br><br>
      </div>
        <div class="panel panel-primary solicitud">
          <div class="panel-heading">Solicitud</div>
            <div class="panel-body">
              <button class="btn btn-primary agregar_sol" type="button">Agregar</button>
              <table class="table tabla_solicitud">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Descripción</th>
                    <th>Unidad de medida</th>
                    <th>Cantidad</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
        </div>
        <div class="panel panel-primary documentos" style="display: none;">
            <div class="panel-heading">Documentos</div>
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
              @if($compra->estado==1)
              <label for="" class="label-primary col-xs-12">Pendiente asignar proveedor</label>
              <button data-id="{{$compra->id}}" class="btn btn-primary proveedor" type="button">Seleccionar proveedor</button>
              @elseif($compra->estado==2) 
              @elseif($compra->estado==3) 
              <label for="" class="label-primary col-xs-12">Aprobada</label>
              @elseif($compra->estado==4) 
              <label for="" class="label-success col-xs-12">Pagada</label>
              @endif
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
                    <span><b>${{ number_format($compra->total,2)}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">

                  <div class="col-sm-12">
                    <span style="font-weight: normal;">Renta:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>${{ number_format($compra->renta,2)}}</b></span>
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
                  <div class="col-sm-12">
                    <span style="font-weight: normal;">Cuenta:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>{{ $compra->cuenta->nombre}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">
                  <div class="col-sm-12">
                    <span style="font-weight: normal;">Proveedor aceptado:</span>
                  </div>
                  <div class="col-sm-12">
                    <span><b>{{ $compra->proveedor->nombre}}</b></span>
                  </div>
                  <div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">
                  <br>
                  @if($compra->estado==1)
                  <a href="javascript:void(0)" class="btn btn-warning editar" data-id="{{$compra->id}}"><i class="fa fa-edit"></i></a>
                  @endif
            </div>
        </div>
    </div>
</div>

@include('directa.modales')

<div id="modal_aqui"></div>

@endsection
@section('scripts')
<script>
  const medidas=JSON.parse('<?php echo $medidas; ?>');
  const materiales=JSON.parse('<?php echo $materiales; ?>');
  const contratacion_id='<?php echo $compra->id; ?>';
$(document).ready(function(e){
  const MAXIMO_TAMANIO_BYTES = 10000000; // 1MB = 1 millón de bytes
  losmateriales();
  $(document).on("click",".agregar",function(e){
    e.preventDefault();
    $("#modal_subir").modal("show");
  });

  //agregar elemento a la solicitud
  $(document).on("click",".agregar_sol",function(e){
    e.preventDefault();
    $(this).prop("disabled",true);
    let sel_medidas=sel_materiales='';
    for(let i=0;i<medidas.length;i++){
      sel_medidas+='<option value="'+medidas[i].id+'">'+medidas[i].nombre_medida+'</option>';
    }

    for(let j=0;j<materiales.length;j++){
      sel_materiales+='<option value="'+materiales[j].id+'">'+materiales[j].nombre+'</option>';
    }
    //console.log(sel_materiales);
    let html='<tr class="lafilita">'+
    '<td></td>'+
    '<td><select class="form-control mate"><option value="">Seleccione </option>'+sel_materiales+'</select></td>'+
    '<td><select class="form-control um"><option value="">Seleccione </option>'+sel_medidas+'</select></td>'+
    '<td><input type="number" class="form-control canti"></td>'+
    '<td>'+
    '<button type="button" class="btn btn-success n_soli"><i class="fa fa-check"></i></button>'+
    '<button type="button" class="btn btn-danger cancel_n"><i class="fa fa-minus"></i></button>'+
    '</td>'+
    '</tr>';
    $(".tabla_solicitud").append(html);
  });

  //cancelar nuevo material
  $(document).on("click",".cancel_n",function(e){
    e.preventDefault();
    $(".lafilita").remove();
    $(".agregar_sol").prop("disabled",false);
  });

  //registrar solicitud
  $(document).on("click",".n_soli",function(e){
    e.preventDefault();
    let material_id='';
    let unidadmedida_id=0;
    let cantidad=0;
    material_id=$(".mate").val();
    unidadmedida_id=$(".um").val();
    cantidad=$(".canti").val();
    $.ajax({
      url:'../directa/eldetalle',
      type:'post',
      dataType:'json',
      data:{contratacion_id,material_id,unidadmedida_id,cantidad},
      success: function(json){
        if(json[0]==1){

        }else{

        }
      },
      error: function(error){
        $.each(error.responseJSON.errors, function( key, value ) {
          toastr.error(value);
          
        });
        swal.closeModal();
      }
    })
  });

  //menu opciones
  $(document).on("click",".que_ver",function(e){
    e.preventDefault();
    let ver=$(this).attr("data-tipo");
    if(ver==1){
      $(".solicitud").show();
      $(".documentos").hide();
    }else{
      $(".solicitud").hide();
      $(".documentos").show();
    }
  });

  //lleva renta?
  $(document).on("change",".renta",function(e){
    e.preventDefault();
    if( $(this).prop('checked') ) {
      $(".sirenta").show();
      $(".larenta").val("");
    }else{
      $(".sirenta").hide();
      $(".larenta").val(0);
      let monto=0;
      monto=parseFloat($(".elmonto").val());
      $(".total").val(monto);
    }
  });

  $(document).on("input",".elmonto,.larenta",function(e){
    e.preventDefault();
    let valor=0;
    let renta=0;
    let total=0;
    renta=parseFloat($(".larenta").val());
    valor=parseFloat($(".elmonto").val());
    total=valor-renta;
    $(".total").val(total.toFixed(2));
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
                $(".chosen-select-width").chosen({width: "100%"});
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

  //seleccionar proveedor

  $(document).on("click",".proveedor",function(e){
    e.preventDefault();
    var id=$(this).attr("data-id");
    $("#modal_proveedor").modal("show");
  });

  $(document).on("click",".nuevo_prov",function(e){
    e.preventDefault();
    $("#modal_proveedor").modal("hide");
    $("#nuevo_proveedor").modal("show");
  });

  $(document).on("click","#cierra_modal",function(e){
    e.preventDefault();
    $("#modal_proveedor").modal("show");
    $("#nuevo_proveedor").modal("hide");
    $("#form_nproveedor").trigger("reset");
  });

    //editar
    $(document).on("click",".puteditar", function(e){
          e.preventDefault();
          var id=$(this).attr("data-id");
          var datos=$("#form_ecompra").serialize();
          modal_cargando();
          $.ajax({
            url:'../directa/'+id,
            type:'put',
            dataType:'json',
            data:datos,
            success:function(json){
              if(json[0]==1){
                toastr.success("Editado con éxito");
                swal.closeModal();
                location.reload();
              }else{
                toastr.error("Ocurrió un error en el servidor");
                swal.closeModal();
              }
            }, error: function(error){
              $.each(error.responseJSON.errors,function(i,v){
                toastr.error(v);
              });
              swal.closeModal();
            }
          })
        });

  //guardar proveedor
  $(document).on("submit","#form_nproveedor",function(e){
    e.preventDefault();
    var datos=$("#form_nproveedor").serialize();
    $.ajax({
      url:'../proveedores',
      type:'post',
      dataType:'json',
      data:datos,
      success:function(data){
          if(data[0]==1){
            toastr.success("proveedor registrado con exito");
            swal.closeModal();
            $("#modal_proveedor").modal("show");
            $("#nuevo_proveedor").modal("hide");
            $("#elprove").append("<option selected value='"+data[3].id+"'>"+data[3].nombre+"</option>");
            $("#elprove").trigger("chosen:updated");
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
    })
  });

  $(document).on("submit","#form_proveedor",function(e){
    e.preventDefault();
    var datos=$("#form_proveedor").serialize();
    $.ajax({
      url:'../directa/proveedor',
      type:'post',
      dataType:'json',
      data:datos,
      success:function(data){
          if(data[0]==1){
            toastr.success("proveedor seleccionado con exito");
            swal.closeModal();
            location.reload();
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
    })
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

 function losmateriales(){
   $.ajax({
     url:'../directa',
     type:'get',
     dataType:'json',
     data:{contratacion_id},
     success: function(json){
      if(json[0]==1){
        $('.tabla_solicitud>body').empty();
        $('.tabla_solicitud').append(json[2]);
      }
     }
   });
 }
</script>
@endsection