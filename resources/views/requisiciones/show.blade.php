@extends('layouts.app')

@section('migasdepan')
<h1>
        &nbsp;
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/requisiciones') }}"><i class="fa fa-balance-scale"></i> Requisiciones</a></li>
        <li class="active">Ver</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Información sobre la requisición <b>{{$requisicion->codigo_requisicion}}<b> </div>
                <div class="panel-body">
                  <div class="pull-right">
                    <a title="Imprimir requisición" href="{{url('reportesuaci/requisicionobra/'.$requisicion->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                  </div>
                    <table class="table">
                      <tr>
                        <th colspan="2">
                          <center>{!! $elestado !!}</center>
                        </th>
                      </tr>
                      <tr>
                        <th>Requisición N°</th>
                        <td>{{ $requisicion->codigo_requisicion}}</td>
                      </tr>
                      <tr>
                        <th>Responsable</th>
                        <td>{{$requisicion->user->empleado->nombre}}</td>
                      </tr>
                      <tr>
                        <th>Actividad</th>
                        <td>{{$requisicion->actividad}}</td>
                      </tr>
                      <tr>
                        <th>Fuente de financiamiento</th>
                        <td>{{$requisicion->fondocat->categoria}}</td>
                      </tr>
                      <tr>
                        <th>Unidad solicitante</th>
                        <td>{{$requisicion->unidad->nombre_unidad}}</td>
                      </tr>
                      <tr>
                        <th>Observaciones</th>
                        <td>{{$requisicion->observaciones}}</td>
                      </tr>
                    </table>

                        <br>
                        
                        
                        @if($requisicion->estado==1)
                      {{ Form::open(['route' => ['requisiciones.destroy', $requisicion->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('/requisiciones/'.$requisicion->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Editar</a> |
                        <button class="btn btn-danger" type="button" onclick="
                        return swal({
                          title: 'Eliminar requisicion',
                          text: '¿Está seguro de eliminar requisicion?',
                          type: 'question',
                          showCancelButton: true,
                          confirmButtonText: 'Si, Eliminar',
                          cancelButtonText: 'No, Mantener',
                          confirmButtonClass: 'btn btn-danger',
                          cancelButtonClass: 'btn btn-default',
                          buttonsStyling: false
                        }).then(function(){
                          submit();
                          swal('Hecho', 'El registro a sido eliminado','success')
                        }, function(dismiss){
                          if(dismiss == 'cancel'){
                            swal('Cancelado', 'El registro se mantiene','info')
                          }
                        })";><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
                      {{ Form::close()}}
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
          <div class="btn-group">
            <button class="btn btn-primary que_ver" data-tipo="1" >Requisiciones</button>
            <button class="btn btn-primary que_ver" data-tipo="2">Solicitud</button>
            <button class="btn btn-primary que_ver" data-tipo="3">Cotizaciones</button>
            <button class="btn btn-primary que_ver" data-tipo="4">Orden de compra</button>
          </div><br><br>
          <div class="panel panel-primary" id="requi" style="display: block;">
            <div class="panel-heading">Detalle</div>
            <div class="panel-body">
              <div>
                <?php if($requisicion->requisiciondetalle->count() > 0): ?>

                    @if($requisicion->estado==1)
                      <center><a class="btn btn-success pull-right" id="agregar_nueva">Agregar Necesidad</a></center><br>
                    @endif
                          <table class="table" id="example2">
                            <thead>
                              <th>Descripción</th>
                              <th>Cantidad</th>
                              <th>Unidad de medida</th>
                              <th></th>
                            </thead>
                            <tbody>
                              @foreach($requisicion->requisiciondetalle as $detalle)
                              <tr>
                                <td>{{$detalle->descripcion}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td>{{$detalle->unidadmedida->nombre_medida}}</td>
                                <td>
                                  @if($requisicion->estado==1)
                                  {{ Form::open(['route' => ['requisiciondetalles.destroy', $detalle->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                                    <div class="btn-group">
                                      <a id="editar_detalle" data-id="{{$detalle->id}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                                        <button class="btn btn-danger btn-xs" type="button" onclick="
                                        return swal({
                                          title: 'Eliminar requisicion',
                                          text: '¿Está seguro de eliminar requisicion?',
                                          type: 'question',
                                          showCancelButton: true,
                                          confirmButtonText: 'Si, Eliminar',
                                          cancelButtonText: 'No, Mantener',
                                          confirmButtonClass: 'btn btn-danger',
                                          cancelButtonClass: 'btn btn-default',
                                          buttonsStyling: false
                                        }).then(function(){
                                          submit();
                                          swal('Hecho', 'El registro a sido eliminado','success')
                                        }, function(dismiss){
                                          if(dismiss == 'cancel'){
                                            swal('Cancelado', 'El registro se mantiene','info')
                                          }
                                        })";><span class="glyphicon glyphicon-trash"></span></button>
                                    </div>
                                  {{ Form::close()}}
                                @endif
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          <?php else: ?>
                            <center>
                              <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                              <span>Agregue requerimientos de materiales</span><br>
                              <button class="btn btn-primary" id="agregar_nueva">Agregar</button>
                            </center>
                      <?php endif; ?>
                        </div>
            </div>
          </div>
          <div class="panel panel-primary" id="soli" style="display: none;">
            <div class="panel-heading">Solicitud de cotización</div>
            <div class="panel">
              <?php if($requisicion->solicitudcotizacion): ?>
                <div class="pull-right">
                    <a title="Imprimir solicitud de cotización" href="{{url('reportesuaci/solicitud/'.$requisicion->solicitudcotizacion->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                  </div>
                  <table class="table">
                    <tr>
                      <td>Número de solicitud</td>
                      <th>{{$requisicion->solicitudcotizacion->numero_solicitud}}</th>
                    </tr>
                    <tr>
                      <td>Encargado</td>
                      <th>{{$requisicion->solicitudcotizacion->encargado}}</th>
                    </tr>
                    <tr>
                      <td>Cargo</td>
                      <th>{{$requisicion->solicitudcotizacion->cargo_encargado}}</th>
                    </tr>
                    <tr>
                      <td>Lugar de entrega</td>
                      <th>{{$requisicion->solicitudcotizacion->lugar_entrega}}</th>
                    </tr>
                    <tr>
                      <td>Fecha límite para cotizar</td>
                      <th>{{$requisicion->solicitudcotizacion->fecha_limite->format("d-m-Y")}}</th>
                    </tr>
                    <tr>
                      <td>Tiempo máximo para entrega de materiales</td>
                      <th>{{$requisicion->solicitudcotizacion->tiempo_entrega}}</th>
                    </tr>
                  </table>
              <?php else: ?>
                <center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>Registre la solicitud</span><br>
                  <button class="btn btn-primary" id="registrar_solicitud">Registrar</button>
                </center>
              <?php endif; ?>
              
              
            </div>
          </div>
          <div class="panel panel-primary" id="coti" style="display: none;">
            <div class="panel-heading">Cotizaciones</div>
            <div class="panel">
              <?php if (isset($requisicion->solicitudcotizacion->cotizacion)): ?>
                <?php if (date("Y-m-d") > $requisicion->solicitudcotizacion->fecha_limite->format('Y-m-d') && $requisicion->estado != 5): ?>
                  <a href="{{url('/cotizaciones/cotizarr/'.$requisicion->solicitudcotizacion->id)}}" class="btn btn-primary pull-right">Ver cuadro comparativo</a>
                <?php else: ?>
                  <?php if($requisicion->estado==3):?>
                    <center><button class="btn btn-primary pull-right" id="registrar_cotizacion">Registrar</button></center>
                  <?php endif; ?>
                <?php endif ?>
                <table class="table" id="example2">
                    <thead>
                      <tr>
                      <th>Proveedor</th>
                      <th>Forma de pago</th>
                      <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($requisicion->solicitudcotizacion->cotizacion as $cotizacion)
                      <tr>
                        <th>{{$cotizacion->proveedor->nombre}}</th>
                        <th>{{$cotizacion->formapago->nombre}}</th>
                        <th>
                          <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-eye"></i></button>
                        </th>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
              <?php elseif ($requisicion->solicitudcotizacion->fecha_limite>date('Y-m-d')): ?>
               
              <?php else: ?>
                 @if(isset($requisicion->solicitudcotizacion))
                 <center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>Registre las cotizaciones</span><br>
                  <button class="btn btn-primary" id="registrar_cotizacion">Registrar</button>
                </center>
                  @else
                  <center>
                    <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <span>Registre primero la solicitud de cotización</span><br>
                    
                  </center>
                  @endif
              <?php endif; ?>
              
              
            </div>
          </div>
          <div class="panel panel-primary" id="orden" style="display: none;">
            <div class="panel-heading">Orden de compra</div>
            <div class="panel">
              @if(isset($orden->numero_orden))
              <table class="table">
                <tr>
                  <td>Número de orden</td>
                  <th>{{$orden->numero_orden}}</th>
                </tr>
                <tr>
                  <td>Dirección de entrega</td>
                  <th>{{$orden->direccion_entrega}}</th>
                </tr>
                <tr>
                  <td>Administrador de la orden</td>
                  <th>{{$orden->adminorden}}</th>
                </tr>
              </table>
              @else
                <center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>Aun no se ha registrado la orden de compra</span><br>
                  <button class="btn btn-primary" id="registrar_orden">Registrar</button>
                </center>
              @endif
            </div>
          </div>
        </div>
    </div>
    <div id="modal_aqui"></div>
</div>
@include('requisiciones.modales')
@endsection
@section('scripts')
<script>
    $(document).ready(function(e){
      listarformapagos();
      var token = $('meta[name="csrf-token"]').attr('content');
      $(document).on("click","#agregar_nueva",function(e){
        e.preventDefault();
        $("#modal_detalle").modal("show");
      });

        $(document).on("click","#agregar_otro",function(e){
          var datos=$("#form_detalle").serialize();
          modal_cargando();
          $.ajax({
            url:'../requisiciondetalles',
            headers: {'X-CSRF-TOKEN':token},
            type:'POST',
            dataType:'json',
            data:datos,
            success:function(json){
              console.log(json);
              if(json[0]==1){
                toastr.success("Necesidad agregada exitosamente");
                window.location.reload();
              }else{
                swal.closeModal();
                toastr.error("Ocurrió un error");
              }
              
            }, error: function(error){
              console.log(error);
              swal.closeModal();
              $.each(error.responseJSON.errors, function( key, value ) {
                  toastr.error(value);
              });
            }
          });
        });

        $(document).on("click","#editar_detalle",function(e){
          e.preventDefault();
          var id=$(this).attr("data-id");
          $.ajax({
            url:'../requisiciondetalles/'+id+'/edit',
            type:'get',
            dataType:'json',
            data:{},
            success: function(json){
              if(json[0]==1){
                $("#modal_aqui").empty();
                $("#modal_aqui").html(json[3]);
                $("#elmodal_editar").modal("show");
              }
            }
          })
        });

        $(document).on("click","#editar_eldetalle",function(e){
          var id=$("#elcodigo_detalle").val();
          var datos=$("#form_editar_eldetalle").serialize();
          modal_cargando();
          $.ajax({
            url:'../requisiciondetalles/'+id,
            headers: {'X-CSRF-TOKEN':token},
            type:'PUT',
            dataType:'json',
            data:datos,
            success: function(json){
              if(json[0]==1){
                toastr.success("Actualizado con éxito");
                window.location.reload();
              }else{
                toastr.error("Ocurrió un error");
                swal.closeModal();
              }
            },error: function(error){
              $.each(error.responseJSON.errors, function( key, value ) {
                  toastr.error(value);
              });
              swal.closeModal();
            }
          });
        });

        $(document).on("click",".que_ver",function(e){
          var opcion=$(this).attr("data-tipo");
          if(opcion==1){
            $("#requi").css("display","block");
            $("#soli").css("display","none");
            $("#coti").css("display","none");
            $("#orden").css("display","none");
          }else if(opcion==2){
            $("#requi").css("display","none");
            $("#soli").css("display","block");
            $("#coti").css("display","none");
            $("#orden").css("display","none");
          }else if(opcion==3){
            $("#requi").css("display","none");
            $("#soli").css("display","none");
            $("#coti").css("display","block");
            $("#orden").css("display","none");
          }else if(opcion==4){
            $("#requi").css("display","none");
            $("#soli").css("display","none");
            $("#coti").css("display","none");
            $("#orden").css("display","block");
          }
        });

        ///*** Registrar cotizaciones ***//
        $(document).on("click","#registrar_cotizacion",function(e){
          e.preventDefault();
          $("#modal_registrar_coti").modal("show");
        });

        $(document).on("keyup",".precios",function(e){
          var element = $(e.currentTarget),
            cantidad   = $(element).attr('data-cantidad'),
            subTotal =  $(element).val(),
            parent  = element.parents("tr");

            if($.isNumeric($(element).val()) && $.trim($(element).val()))
              subTotal = ( $(element).val() * parseFloat(cantidad) );
            else
              subTotal = 0
            //console.log(parent);
            $(parent).find(".subtotal").text("$"+subTotal.toFixed(2));
        });

         $(document).on("click","#registrar_lacoti", function(e){
          var marcas = new Array();
          var precios = new Array();
          var unidades = new Array();
          var descripciones = new Array();
          var cantidades = new Array();
          $('input[name^="marcas"]').each(function() {
            marcas.push($(this).val());
          });

          $('input[name^="precios"]').each(function() {
            precios.push($(this).val());
          });

          $('input[name^="unidades"]').each(function() {
            unidades.push($(this).val());
          });

          $('input[name^="descripciones"]').each(function() {
            descripciones.push($(this).val());
          });

          $('input[name^="cantidades"]').each(function() {
            cantidades.push($(this).val());
          });

          var proveedor = $("#proveedor").val();
          var descripcion = $(".laformapago").val();
          var id = $("#id").val();

          $.ajax({
            url:'../cotizaciones',
            headers: {'X-CSRF-TOKEN':token},
            type:'post',
            data:{id,proveedor,descripcion,marcas,precios,cantidades,unidades,descripciones},
            success: function(response){
              if(response[0]==1){
                toastr.success("Cotización registrada exitosamente");
                if(response[2].tipo == 1){
                  location.href="../../solicitudcotizaciones/versolicitudes/"+response.proyecto;
                }else{
                  location.reload();
                  $("#requi").css("display","none");
                  $("#soli").css("display","none");
                  $("#coti").css("display","block");
                }
              }else{
                toastr.error("Debe llenar todos los campos de precio unitario");
                console.log(response);
              }
            },
            error: function(error){
              console.log(error);
              $.each(error.responseJSON.errors, function( key, value ) {
                toastr.error(value);
              });
            }
          });
        });

         $(document).on("click","#registrar_solicitud",function(e){
          e.preventDefault();
          $("#modal_registrar_soli").modal("show");
         });

         $(document).on("click","#agregar_soli", function(e){
          var formapago = $("#formapago").val();
          var encargado = $("#encargado").val();
          var cargo = $("#cargo").val();
          var requisicion = $("#requisicion").val();
          var unidad = $("#unidad").val();
          var lugar_entrega = $("#lugar_entrega").val();
          var fecha_limite = $("#fecha_limite").val();
          var tiempo_entrega = $("#tiempo_entrega").val();

          $.ajax({
            url:'../solicitudcotizaciones/storer',
            headers: {'X-CSRF-TOKEN':token},
            type:'post',
            data:{formapago,encargado,cargo,requisicion,unidad,lugar_entrega,fecha_limite,tiempo_entrega},
            success: function(response){
              if(response.mensaje=='exito'){
                toastr.success('Solicitud registrada exitosamente');
                location.reload();
              }else{
                  console.log(response);
                  toastr.error('Ocurrió un error, contacte al administrador');
                }
            },
            error: function(error){
              console.log(error);
              $.each(error.responseJSON.errors, function( key, value ) {
                toastr.error(value);
              });
            }
          });
        });
    });

 function listarformapagos()
  {
    $.ajax({
      url:'../formapagos',
      type:'get',
      data:{},
      success:function(data){
        var html_select = '<option value="">Seleccione una forma de pago</option>';
          $(data).each(function(key, value){
            html_select +='<option value="'+value.id+'">'+value.nombre+'</option>'
            //console.log(data[i]);
            $("#formapago").html(html_select);
            $(".laformapago").html(html_select);
            $("#formapago").trigger('chosen:updated');
            $(".laformapago").trigger('chosen:updated');

          });
          //console.log(data);
      }
    });
  }
</script>
@endsection
