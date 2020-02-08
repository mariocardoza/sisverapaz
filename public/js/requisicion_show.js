$(document).ready(function(e){
 
      info(elid);
      listarformapagos();
      inicializar_tabla("tabla_requi");

      var token = $('meta[name="csrf-token"]').attr('content');

      $(document).on("click","#agregar_nueva",function(e){
        e.preventDefault();
        
        //var latabla=$("#latabla").DataTable();
        listarmateriales(elid);
        $("#modal_detalle").modal("show");
      });

      //agregar materiales sin presupuesto
      $(document).on("click","#agregar_nueva_sin", function(e){
        e.preventDefault();
        selectmateriales(elid);
        $("#cantiti").val("");
        $("#modal_detalle_sin").modal("show");
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
              data:{fecha_acta:'si',estado:6},
              success: function(json){
                if(json[0]==1){
                  info(elid);
                  toastr.success("Materiales recibidos");
                }else{
                  toastr.error("Ocurrió un error");
                }
              }, error: function(error){

              }
            });
            swal(
              '¡Éxito!',
              'Materiales ya en posesión del encargando',
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

      ///aprobar la requisicion
      $(document).on("click","#modal_aprobar",function(e){
        e.preventDefault();
        $("#modal_aprobar_requisicion").modal("show");
      });

      $(document).on("click","#aprobar_requisicion", function(e){
        var valid=$("#form_aprobarrequi").valid();
        if(valid){
          var datos=$("#form_aprobarrequi").serialize();
          modal_cargando();
          $.ajax({
            url:'../requisiciones/aprobar',
            type:'POST',
            dataType:'json',
            data:datos,
            success: function(json){
              if(json[0]==1){
                toastr.success("Aprobada con exito");
                swal.closeModal();
                $("#modal_aprobar_requisicion").modal("hide");
                info(elid);
                $(".skin-blue").css("padding-right", "0px");
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
        }
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
              $(".chosen-select-width").chosen({'width':'100%'});
            }
          }
        })
      });

      $(document).on("click","#eliminar_detalle",function(e){
        e.preventDefault();
        var id=$(this).attr("data-id");
        $.ajax({
          url:'../requisiciondetalles/'+id,
          type:'DELETE',
          dataType:'json',
          data:{},
          success: function(json){
            if(json[0]==1){
              info(elid);
              toastr.success('Eliminado exitosamente');
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
              info(elid);
              $("#elmodal_editar").modal("hide");
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
          info(elid);
          $("#requi").css("display","none");
          $("#soli").css("display","block");
          $("#coti").css("display","none");
          $("#orden").css("display","none");
        }else if(opcion==3){
          mostrar_contrato(elid);
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
        var id=$(this).attr("data-id");
        $.ajax({
          url:'../solicitudcotizaciones/modal_cotizacion/'+id,
          type:'get',
          data:{},
          success:function(json){
            if(json[0]==1){
              $("#modal_aqui").empty();
              $("#modal_aqui").html(json[2]);
              $(".chosen-select-width").chosen({
                width:"100%"
              });
              $("#modal_registrar_coti").modal("show");
            }
          }
        })
      });

      /// Obtener la solicitud
      $(document).on("click","#lasolicitud",function(e){
        var id=$(this).attr("data-id");
        mostrar_informacion(id);
      });

      ////*** Seleccionar la cotizacion */
      $(document).on("click","#seleccionar",function(e){
        idcot = $(this).attr("data-id");
        idrequisicion = $(this).attr('data-requisicion');
        swal({
          title: '¿Está seguro?',
          text: "¿Desea seleccionar este proveedor?",
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
            swal(
              '¡Seleccionado!',
              'Proveedor seleccionado.',
              'success'
            )
            seleccionarr(idcot,idrequisicion);
          } else if (result.dismiss === swal.DismissReason.cancel) {
            swal(
              'Cancelado',
              'Seleccione un proveedor',
              'info'
            )
            $('input[name=seleccionarr]').attr('checked',false);
          }
        });
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
        var id = $("#id_solicoti").val();
        modal_cargando();
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
                mostrar_informacion(response[2]);
                $("#modal_registrar_coti").modal("hide");
                swal.closeModal();
              }
            }else{
              toastr.error("Debe llenar todos los campos de precio unitario");
              console.log(response);
              swal.closeModal();
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
        var id=$(this).attr("data-id");
        $.ajax({
          url:'../requisiciones/formulariosoli/'+id,
          type:'get',
          dataType:'json',
          success: function(json){
            if(json[0]==1){
              $("#elformulario").empty();
              $("#elformulario").html(json[2]);
              $("#elshow").hide();
              $("#elformulario").show();
              $(".chosen-select-width").chosen({'width':'100%'});
              var inicio = new Date();
              var fin = new Date(fecha_acti);
              $('.unafecha').datepicker({
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy',
                minDate: inicio,
                maxDate: fin,
                format: 'dd-mm-yyyy'
                });
            }
          }
        });
        //$("#modal_registrar_soli").modal("show");
      });

      $(document).on("click","#subir_contrato", function(e){
      e.preventDefault();
      $("#modal_subir_contrato").modal("show");
      });

      $(document).on("click","#btn_subir_contrato",function(e){
      var formData = $("#form_subircontrato").serialize();
      
      $.ajax({
        url:'../requisiciones/subircontrato',
        type:'POST',
        dataType:'json',
        data:formData,
        success:function(json){

        }
      });
      });

      $(document).on('submit','#form_subircontrato', function(e) {
        // evito que propague el submit
        e.preventDefault();
        modal_cargando();
        // agrego la data del form a formData
        var formData = new FormData(this);
        formData.append('_token', $('input[name=_token]').val());
      
        $.ajax({
            type:'POST',
            url:'../requisiciones/subircontrato',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data[0]==1){
                  toastr.success("Contrato subido con exito");
                  mostrar_contrato(data[2]);
                  $("#modal_subir_contrato").modal("hide");
                  $("#form_subircontrato").trigger("reset");
                  swal.closeModal();
                }
            },
            error: function(error){
              $.each(error.responseJSON.errors, function( key, value ) {
                toastr.error(value);
                swal.closeModal();
              });
            }
        });
      });

      $(document).on('submit','#form_subiracta', function(e) {
        // evito que propague el submit
        e.preventDefault();
        var elarchivo=$("#file-upload2").val();
        if(elarchivo!=''){
          
        //modal_cargando();
        // agrego la data del form a formData
        var tamanio=0;
        var formData = new FormData(this);
        formData.append('_token', $('input[name=_token]').val());
        var fi= document.getElementById('file-upload2');
         tamanio =fi.files[0].size/1024/1024;
        console.log(tamanio +"MB");
        if(tamanio <= 10){
            $.ajax({
              type:'POST',
              url:'../requisiciones/subir', 
              data:formData,
              cache:false,
              contentType: false,
              processData: false,
              success:function(data){
                  if(data[0]==1){
                    toastr.success("Acta subida con éxito");
                    info(data[2]);
                    $("#modal_finalizar").modal("hide");
                    $("#form_subiracta").trigger("reset");
                    swal.closeModal();
                  }
              },
              error: function(error){
                  swal.closeModal();
                $.each(error.responseJSON.errors, function( key, value ) {
                  toastr.error(value);
                  swal.closeModal();
                });
              }
          });
        }else{
          toastr.error('El archivo debe pesar menos de 10MB');
        }
        }else{
          toastr.error("Debe seleccionar un acta");
        }
        
  });

  $(document).on("click","#cancelar_soli",function(e){
		e.preventDefault();
		$("#elshow").show();
		$("#elformulario").hide();
		$("#form_solicitudcotizacion").trigger("reset");
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
      var requi=new Array();
      var chec=$(document).find(".lositemss");
      $.each(chec,function(i,v){
        if($(v).is(":checked")){
          requi.push({
            idcambiar:$(this).attr("data-idcambiar"),
            idmaterial:$(this).attr("data-material"),
            cantidad:$(this).attr("data-cantidad")
          });
        }
      });

      // if(requi.length==0){
        //swal('aviso','Seleccione los ítems','warning');
      //}else{
        $.ajax({
          url:'../solicitudcotizaciones/storer',
          headers: {'X-CSRF-TOKEN':token},
          type:'post',
          data:{formapago,encargado,cargo,requisicion,unidad,lugar_entrega,fecha_limite,tiempo_entrega,requi},
          success: function(response){
            if(response.mensaje=='exito'){
              toastr.success('Solicitud registrada exitosamente');
              info(elid);
              $("#elshow").show();
		          $("#elformulario").hide();
		          $("#form_solicitudcotizacion").trigger("reset");
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
      //}
      });

      $(document).on("click","#registrar_orden", function(e){
        var id=$(this).attr("data-id");
        $.ajax({
          url:'../ordencompras/modal_registrar/'+id,
          type:'get',
          data:{},
          success: function(json){
            if(json[0]==1){
              $("#elformulario").empty();
              $("#elformulario").html(json[2]);
              $("#elshow").hide();
              $("#elformulario").show();
              var start = new Date(),
              end = new Date(fecha_acti),
              start2, end2;
              console.log(start,end);
  
              $("#fecha_inicio").datepicker({
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-mm-yy',
                minDate: start,
                maxDate: end,
              onSelect: function(){
                start2 = $(this).datepicker("getDate");
                end2 = $(this).datepicker("getDate");

                start2.setDate(start2.getDate() + 1);
                end2.setDate(end2.getDate() + 365);

                $("#fecha_fin").datepicker({
                        selectOtherMonths: true,
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'dd-mm-yy',
                        minDate: start2,
                        maxDate: end,
                onSelect: function(){
                  var fecha1 = moment(start2);
                  var fecha2 = moment($(this).datepicker("getDate"));
                  //$("#plazo").val(fecha2.diff(fecha1, 'days');
                }
                });

              }
            });
              $("#modal_registrar_orden").modal("show");
            }
          }
        });
      //
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
            mostrar_informacion(json[2]);
            info(elid);
            $("#elshow").show();
            $("#elformulario").hide();
            $("#elformulario").empty();
            $("#laordencompra").trigger("reset");
            swal.closeModal();
            //window.location.reload();
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

      $(document).on("click",".esteagrega", function(e){
        var material=$(this).attr("data-material");
        var disponible=$(this).attr("data-disponible");
        $.ajax({
          url:'../requisiciones/modalagregar',
          type:'POST',
          dataType:'json',
          data:{material,disponible,elid},
          success: function(json){
            if(json[0]==1){
              $("#modal_aqui").empty();
              $("#modal_aqui").html(json[2]);
              $("#modal_detalle").modal("hide");
              $("#modal_registrar_material").modal("show");
            }
          }
        });

       

        /*if(numero == 0 || isNaN(numero)){
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
        }*/
      });

      $(document).on("click","#registrar_mate",function(e){
        var valid=$("#form_material").valid();
        if(valid){
          
            var datos=$("#form_material").serialize();
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
                  swal.closeModal();
                  $("#modal_registrar_material").modal("hide");
                  $("#modal_detalle").modal("show");
                  $("#estecanti").val("");
                  listarmateriales(elid);
                  info(elid);
                  //$(".canti").val("");
                  //$("#tabla_requi").load(" #tabla_requi");
                  inicializar_tabla("tabla_requi");
                  //window.location.reload();
                }else if(json[0]==2){
                  toastr.warning(json[2]);
                  swal.closeModal();
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

      //registrar material sin presupuesto
      $(document).on("click","#registrar_mate_sin", function(e){
        e.preventDefault();
        
        var requisicion_id=elid;
        var materiale_id=$("#sel_mate_sin").val();
        var unidad_medida=$("#sel_mate_sin option:selected").attr("data-unidad");
        var cantidad=$("#cantiti").val();
        if(cantidad>0){
          modal_cargando();
          $.ajax({
            url:'../requisiciondetalles/guardar',
            type:'POST',
            dataType:'json',
            data:{requisicion_id,materiale_id,cantidad,unidad_medida},
            success: function(json){
              if(json[0]==1){
                selectmateriales(elid);
                info(elid);
                toastr.success("Necesidad agregada exitosamente");
                swal.closeModal();
                $("#cantiti").val("");
              }else{
                swal.closeModal();
                  toastr.error("Ocurrió un error");
              }
            },
            error: function(error){
              swal.closeModal();
              $.each(error.responseJSON.errors, function( key, value ) {
                  toastr.error(value);
              });
            }
          });
        }else{
          toastr.info("Digite un cantidad mayor a cero");
        }
      });

      $(document).on("change","#todos",function(e){
        if( $(this).is(':checked') ) {
          $('.lositems').prop('checked', true);
        }else{
          $('.lositems').prop('checked', false);
        }
      });

      $(document).on("change",".lositems",function(e){
        if(! $(this).is(':checked') ) {
          $('#todos').prop('checked', false);
        }
      });

      //eliminar la requisicion
      $(document).on("click","#quita_requi",function(e){
        $("#modal_darbaja").modal("show");
        
      });

      $(document).on("click","#dar_baja", function(e){
        var valid=$("#form_darbaja").valid();
        if(valid){
          modal_cargando();
          var datos=$("#form_darbaja").serialize();
          $.ajax({
            url:'../requisiciones/darbaja',
            type:'POST',
            dataType:'json',
            data:datos,
            success: function(json){
              if(json[0]){
                swal.closeModal();
                toastr.success("Requisición eliminada con éxito");
                $("#modal_darbaja").modal("hide");
                info(elid);
              }else{
                toastr.error("Ocurrió un error, contacte al administrador");
                swal.closeModal();
                $("#modal_darbaja").modal("hide");
              }
            },error: function(error){
              toastr.error("Ocurrió un error, contacte al administrador");
              swal.closeModal();
              $("#modal_darbaja").modal("hide");
            }
          });
        }
      });
    });

  function mostrar_contrato(id){
    modal_cargando();
      $.ajax({
        url:'../requisiciones/mostrarcontrato/'+id,
        type:'GET',
        data:{},
        success: function(json){
          if(json[0]==1){
            swal.closeModal();
            $("#aqui_contra").empty();
            $("#aqui_contra").html(json[2]);
            inicializar_tabla("latabla");
          }else{
            swal.closeModal();
          }
        }, error: function(error){
          swal.closeModal();
        }
      });
  }

  function mostrar_informacion(id)
  {
    modal_cargando();
      $.ajax({
        url:'../requisiciones/versolicitud/'+id,
        type:'GET',
        data:{},
        success: function(json){
          if(json[0]==1){
            swal.closeModal();
            $("#aquilasoli").empty();
            $("#aquilasoli").html(json[2]);
          }else{
            swal.closeModal();
          }
        }, error: function(error){
          swal.closeModal();
        }
      });
  }

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
      url:'../requisiciones/presupuesto/'+id,
      type:'get',
      data:{},
      success:function(data){
        if(data[0]==1){
          $("#dibujar_materiales").empty();
          $("#dibujar_materiales").html(data[2]);
          inicializar_tabla("latabla");
        }
      }
    });
  }

  function selectmateriales(id)
  {
    $.ajax({
      url:'../requisiciones/materiales/'+id,
      type:'get',
      data:{},
      success:function(data){
        if(data[0]==1){
          $("#sel_mate_sin").empty();
          $("#sel_mate_sin").html(data[4]);
          $("#sel_mate_sin").chosen({'width':'100%'});
          $("#sel_mate_sin").trigger("chosen:updated");
        }
        console.log(data);
      }
    });
  }

  function seleccionarr(idcot,idrequisicion)
  {
    var ruta ="../cotizaciones/seleccionarr";
    $.ajax({
      url: ruta,
			type: 'POST',
			data:{idcot,idrequisicion},

			success: function(data){
        console.log(data);
        if(data[0]== 1){
          toastr.success('Proveedor seleccionado con éxito');
          mostrar_informacion(data[2]);
          info(elid);
        }else{
          toastr.error('Ha ocurrido un error en la solucitud contacte al administrador');
          console.log(data.mensaje);
        }

			},
			error: function(data, textStatus, errorThrown){
        console.log(data);
				toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
				$.each(data.responseJSON.errors, function( key, value ) {
					toastr.error(value);
			});
			}
    });
  }

  function cambiar(){
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info3').innerHTML = pdrs;
  }

  function cambiar2(){
    var pdrs = document.getElementById('file-upload2').files[0].name;
    document.getElementById('info4').innerHTML = pdrs;
  }

  function info(id){
    modal_cargando();
    $.ajax({
      url:'../requisiciones/informacion/'+id,
      type:'GET',
      data:{},
      success: function(json){
        if(json[0]==1){
          swal.closeModal();
          $("#info_aquii").empty();
          $("#body_requi").empty()
          $("#aquiponer_soli").empty();
          $("#info_aquii").html(json[1]);
          $("#body_requi").html(json[2]);
          $("#aquiponer_soli").html(json[3]);
          inicializar_tabla("tabla_requi2");
        }else{
          swal.closeModal();
        }
      }, error: function(error){
        swal.closeModal();
      }
    });
  }