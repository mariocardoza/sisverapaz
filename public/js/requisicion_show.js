$(document).ready(function(e){
      
      listarformapagos();
      inicializar_tabla("tabla_requi");
      var token = $('meta[name="csrf-token"]').attr('content');
      $(document).on("click","#agregar_nueva",function(e){
        e.preventDefault();
        
        //var latabla=$("#latabla").DataTable();
        listarmateriales(elid);
        $("#modal_detalle").modal("show");
      });

      $(document).on("click","#terminar_proceso", function(e){
        e.preventDefault();
        $("#modal_finalizar").modal("show");
      });

      $(document).on("click","#materiales_recibidos", function(e){
        swal({
          title: 'Materiales',
          text: "¿Los materiales se recibieron segun lo estipulado en la solicitud?",
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
            $.ajax({
              url:'../requisiciones/cambiarestado/'+elid,
              type:'PUT',
              dataType:'json',
              data:{estado:6},
              success: function(json){
                if(json[0]==1){
                  location.reload();
                  toastr.success("Materiales recibidos");
                }else{
                  toastr.error("Ocurrió un error");
                }
              }, error: function(error){

              }
            });
            swal(
              '¡Éxito!',
              'Materiales ya en poseción del encargando',
              'success'
            );
          } else if (result.dismiss === swal.DismissReason.cancel) {
            swal(
              'Nueva revisión',
              'Se pide verificar bien los materiales',
              'info'
            );
          }
        });
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

         $(document).on("click","#registrar_orden", function(e){
          $("#modal_registrar_orden").modal("show");
         });

         $(document).on("click","#agregar_orden", function(e){
          var datos= $("#laordencompra").serialize();
          modal_cargando();
          $.ajax({
            url:'../ordencompras',
            type:'POST',
            dataType:'json',
            data:datos,
            success: function(json){
              if(json[0]==1){
                toastr.success("Orden de compra registrada con éxito");
                window.location.reload();
              }else{
                swal.closeModal();
                toastr.error("Ocurrió un error");
              }
            },error: function(error){
              swal.closeModal();
                $.each(error.responseJSON.errors, function( key, value ) {
                    toastr.error(value);
                });
            }
          });
         });


         ///ver cotizaciones //
         $(document).on("click","#ver_coti",function(e){
          var id=$(this).attr("data-id");
          $.ajax({
            url:'../requisiciones/vercotizacion/'+id,
            type:'GET',
            dataType:'json',
            data:{},
            success:function(json){
              if(json[0]==1){
                $("#aqui_poner_coti").empty();
                $("#aqui_poner_coti").html(json[2]);
                $("#titulo_ver_coti").text(json[3]);
                $("#modal_ver_coti").modal("show");
              }
            }
          });
         });

        $(document).on("click","#esteagrega", function(e){
          var td=$(this).parents("tr").children('td:eq(4)');
          var numero = parseFloat($(td).children('input').val());
          var material=$(this).attr("data-material");
          var unidad=$(this).attr('data-unidad');
          var id=$(".elid").val();
          if(numero == 0 || isNaN(numero)){
            swal('Aviso','Digite una cantidad');
          }else{
            modal_cargando();
            $.ajax({
              url:'../requisiciondetalles',
              headers: {'X-CSRF-TOKEN':token},
              type:'POST',
              dataType:'json',
              data:{requisicion_id:id,cantidad:numero,unidad_medida:unidad,materiale_id:material},
              success:function(json){
                console.log(json);
                if(json[0]==1){
                  toastr.success("Necesidad agregada exitosamente");
                  swal.closeModal();
                  listarmateriales(elid);
                  $(".canti").val("");
                  //$("#tabla_requi").load(" #tabla_requi");
                  inicializar_tabla("tabla_requi");
                  //window.location.reload();
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
          }
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

   function listarmateriales(id)
  {
    $.ajax({
      url:'../requisiciones/materiales/'+id,
      type:'get',
      data:{},
      success:function(data){
        if(data[0]==1){
          $("#losmateriales").empty();
          //console.log(latabla);
          //latabla.clear();
          $("#losmateriales").html(data[2]);
          var latabla=inicializar_tabla("latabla");
          var valor = 0;
          /**$("#latabla tbody tr").each(function(){
            console.log($(this).find('td:eq(1)').text());
            latabla.row.add([
              $(this).find('td:eq(0)').text(),
              $(this).find('td:eq(1)').text(),
              $(this).find('td:eq(2)').text(),
              $(this).find('td:eq(3)').text(),
              $(this).find('td:eq(4)').text()
              ]);
          });
          latabla.draw();*/
          //console.log(data);
          
          //latabla.destroy();

        }
      }
    });
  }