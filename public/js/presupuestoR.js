$(document).ready(function () {
	var catalogo_original = [];
	var catalogo_en_uso = [];
	var catalogo_original_index = [];
	var total = 0;
	carga_item();
	cargar_presupuesto(elid);

	$("#item").on('change',function () { 
		var id = $("#item").val();
		var select = $("#descripcion_item");
		if (id != "") {
			modal_cargando();
			$.ajax({
				url:'../presupuestos/getcatalogo/' + id+'/'+preid,
				type:'get',
				dataType:'json',
				success: function(json){
					swal.closeModal();
					select.empty();
					select.append('<option value="">Seleccione una descripción</option>');
					catalogo_original = [];
					catalogo_original_index = [];
					$(json).each(function (k, v) { 
						catalogo_original.push(v);
						catalogo_original_index.push(v.id);
						var html = '<option data-nombre="'+v.nombre+'" value="' + v.id + '">' + v.nombre + '</option>';
						select.append(html);
					});
					select.trigger('chosen:updated');
				},
				error: function(error){
					swal.closeModal();
					toastr.error("Ocurrió un error al cargar los datos");
				}

			});
			
		} else {
			select.empty();
			select.append('<option value="">Seleccione un item primero</option>');
			select.trigger('chosen:updated');
		}
		$("#add_catalogo").prop('disabled',true);
	});

	$("#descripcion_item").change(function () {
		var valor = $(this).val();
		if (valor != "") {
			$("#add_catalogo").prop('disabled', false);
		} else {
			$("#add_catalogo").prop('disabled', true);
		}
	});

	$("#add_catalogo").click(function () { 
		var descripcion = $("#descripcion_item option:selected").data("nombre");
		var id_desc = $("#descripcion_item").val();
		var cantidad = $("#cantidad").val();
		var precio = $("#precio").val();
		var unidad = $("#unidad_medida option:selected").text();
		var idunidad=$("#unidad_medida").val() || 0;
		var select = $("#descripcion_item");

		var tabla = $("#tabla_detalle");

		var html = '<tr data-medida="' + id_desc + '" data-unidad="'+idunidad+'" data-cantidad="' + cantidad + '" data-precio="' + precio + '">' +
			'<td>' + descripcion + '</td>' +
			'<td>' + unidad + '</td>' +
			'<td>' + cantidad + '</td>' +
			'<td>$ ' + parseFloat(precio).toFixed(2) + '</td>' +
			'<td>$ ' + parseFloat(cantidad * precio).toFixed(2) + '</td>' +
			'<td></td>'+
			'</tr>';
		
		cantidad = parseFloat(cantidad);
		precio = parseFloat(precio);
		total += (cantidad * precio);

		catalogo_en_uso.push(id_desc);

		select.empty();
		select.append('<option value="">Seleccione una descripción</option>');
		$(catalogo_original).each(function (k, v) { 
			if (catalogo_en_uso.indexOf(catalogo_original_index[k]) == -1) {
				var html = '<option data-nombre="'+v.nombre+'" value="' + v.id + '">' + v.nombre +'</option>';
				select.append(html);
			}
			select.trigger('chosen:updated');
		});

		$("#add_catalogo").prop('disabled', true);
		$("#item").prop('disabled', true).trigger('chosen:updated');

		$("#total").text("");
		$("#total").text('$ ' + total.toFixed(2));
		
		$("#cantidad").val("1");
		$("#precio").val("1");
		tabla.append(html);
	});

	$("#sav").click(function (e) {
		e.preventDefault();

		var ruta = "../presupuestos";
		var token = $('meta[name="csrf-token"]').attr('content');
		var proyecto_id = $("#proyecto").val();
		var categoria_id = $("#descripcion_item").val();
		var presupuestos = new Array();
		$(cuerpito).find("tr").each(function (index, element) {
			console.log(element);
			if (element) {
				presupuestos.push({
					material: $(element).attr("data-medida"),
					cantidad: $(element).attr("data-cantidad"),
					medida: $(element).attr("data-unidad"),
					precio: $(element).attr("data-precio")
				});
			}
		});
		console.log(presupuestos);
		modal_cargando();

		/////////////////////////////////////////////////// funcion ajax para guardar ///////////////////////////////////////////////////////////////////
		$.ajax({
			url: ruta,
			headers: { 'X-CSRF-TOKEN': token },
			type: 'POST',
			dataType: 'json',
			data: { proyecto_id:elid, total, presupuestos },
			success: function (msj) {
				if (msj[0] == 1) {
					//window.location.href = "../proyectos";
					console.log(msj);
					toastr.success('Presupuesto registrado éxitosamente');
					location.reload();
				} else {
					console.log(msj);
					swal.closeModal();
					toastr.error("Ocurrió un error");
				}

			},
			error: function (data, textStatus, errorThrown) {
				toastr.error('Ha ocurrido un ' + textStatus + ' en la solucitud');
				$.each(data.responseJSON.errors, function (key, value) {
					toastr.error(value);
				});
				swal.closeModal();
			}
		});
	});

	$("#edit").click(function (e) {
		modal_cargando();
		e.preventDefault();

		var ruta = "../presupuestos/"+preid;
		var presupuestos = new Array();
		$(cuerpito).find("tr").each(function (index, element) {
			if (element) {
				presupuestos.push({
					material: $(element).attr("data-medida"),
					cantidad: $(element).attr("data-cantidad"),
					precio: $(element).attr("data-precio"),
					medida: $(element).attr("data-unidad")
				});
			}
		});
		//console.log(presupuestos);

		/////////////////////////////////////////////////// funcion ajax para editar ///////////////////////////////////////////////////////////////////
		modal_cargando();
		$.ajax({
			url: ruta,
			type: 'PUT',
			dataType: 'json',
			data: { presupuestos },
			success: function (json) {
				console.log(json);
				if (json[0] == 1) {
					//window.location.href = "../proyectos";
					toastr.success('Presupuesto agregado éxitosamente');
					cargar_presupuesto(elid);
					swal.closeModal();
					$("#descripcion-item").trigger('chosen:updated');
					$("#item").prop('disabled', false);
					$("#item").trigger('chosen:updated');
				} else {
					console.log(json);
					toastr.error("Ocurrió un error");
					swal.closeModal();
				}

			},
			error: function (data, textStatus, errorThrown) {
				toastr.error('Ha ocurrido un ' + textStatus + ' en la solucitud');
				$.each(data.responseJSON.errors, function (key, value) {
					toastr.error(value);
				});
				swal.closeModal();
			}
		});
	});

	//juegos de los checkboxs

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
	//cargar formulario de solicitud
	$(document).on("click","#registrar_solicitud",function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		$.ajax({
			url:'../proyectos/formulariosoli/'+id,
			type:'GET',
			dataType:'json',
			success: function(json){
				if(json[0]==1){
					$("#elformulario").empty();
					$("#elformulario").html(json[2]);
					$("#elshow").hide();
					$("#elformulario").show();
					$(".chosen-select-width").chosen({'width':'100%'});
					var inicio=new Date();
					$('.unafecha').datepicker({
						selectOtherMonths: true,
						changeMonth: true,
						changeYear: true,
						dateFormat: 'dd-mm-yy',
						minDate: inicio,
						format: 'dd-mm-yyyy'
						});
				}
			}
		});
		
	});
	$(document).on("click","#cancelar_soli",function(e){
		e.preventDefault();
		$("#elshow").show();
		$("#elformulario").hide();
		$("#form_solicitudcotizacion").trigger("reset");
	});

	//area para las solicitudes
	$(document).on("click","#lasolicitud",function(e){
		var id=$(this).attr('data-id');
		mostrar_solicitud(id);
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
	  

	/// registrar la solicitud de cotizacion
	$(document).on("click","#registrar_soli", function(e){
		var formapago = $("#formapago").val();
		var encargado = $("#encargado").val();
		var cargo = $("#cargo").val();
		var proyecto = $("#proyecto").val();
		var unidad = $("#unidad").val();
		var lugar_entrega = $("#lugar_entrega").val();
		var fecha_limite = $("#fecha_limite").val();
		var tiempo_entrega = $("#tiempo_entrega").val();
		var presu=new Array();
		var chec=$(document).find("#cuerpo2").find(".lositemss");
		$.each(chec,function(i,v){
		  if($(v).is(":checked")){
			presu.push({
			  idcambiar:$(this).attr("data-idcambiar"),
			  idmaterial:$(this).attr("data-material"),
			  cantidad:$(this).attr("data-cantidad"),
			  unidad:$(this).attr("data-unidad"),
			});
		  }
		});
  
		// if(requi.length==0){
		  //swal('aviso','Seleccione los ítems','warning');
		//}else{
			modal_cargando();
		  $.ajax({
			url:'../solicitudcotizaciones',
			type:'post',
			data:{formapago,encargado,cargo,proyecto,unidad,lugar_entrega,fecha_limite,tiempo_entrega,presu},
			success: function(response){
			  if(response[0]==1){
				toastr.success('Solicitud registrada exitosamente');
				informacion(response[2]);
				solicitudes(response[2]);
				$("#elshow").show();
				$("#elformulario").hide();
				$("#form_solicitudcotizacion").trigger("reset");
				swal.closeModal();
			  }else{
				  console.log(response);
				  toastr.error('Ocurrió un error, contacte al administrador');
				  swal.closeModal();
				}
			},
			error: function(error){
			  console.log(error);
			  $.each(error.responseJSON.errors, function( key, value ) {
				toastr.error(value);
			  });
			  swal.closeModal();
			}
		  });
		//}
	});

	//registrar la cotizacion
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
              if(response[4] == 1){
				mostrar_solicitud(response[2]);
				informacion(elid);
				$("#modal_registrar_coti").modal("hide");
                swal.closeModal();
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
			swal.closeModal();
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
			  $("#modal_aqui").empty();
			  $("#modal_aqui").html(json[2]);
			  //$("#titulo_ver_coti").text(json[3]);
			  $("#modal_ver_coti").modal("show");
			}
		  }
		});
		});
	  
	  ////*** Seleccionar la cotizacion */
      $(document).on("click","#seleccionar",function(e){
        idcot = $(this).attr("data-id");
        idproyecto = $(this).attr('data-proyecto');
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
            seleccionar(idcot,idproyecto);
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

	  ////*** Seleccionar la oferta */
      $(document).on("click","#ofertita",function(e){
        idoferta = $(this).attr("data-id");
        idproyecto = $(this).attr('data-proyecto');
        swal({
          title: '¿Está seguro?',
          text: "¿Desea seleccionar esta oferta?",
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
				url:'../proyectos/seleccionaroferta',
				type:'POST',
				dataType:'json',
				data:{licitacion_id:idoferta,proyecto_id:idproyecto},
				success: function(json){
					if(json[0]==1){
						toastr.success("Oferta seleccionada con éxito");
						licitacion(elid);
						informacion(elid);
					}else{
						toastr.error('Ocurrió un error');
					}
				}
			});          
          } else if (result.dismiss === swal.DismissReason.cancel) {
            swal(
              'Cancelado',
              'Seleccione un proveedor',
              'info'
            )
            $('input[name=liciti]').attr('checked',false);
          }
        });
	  });
	  
	//modla para registrar la orden de compra
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
			  $("#elformulario").show();
			  $("#elshow").hide();
              var start = new Date(),
              end = new Date(),
              start2, end2;
              end.setDate(end.getDate() + 365);
  
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
                        maxDate: end2,
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
	  
	//registra la orden de compra
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
			  mostrar_solicitud(json[2]);
			  informacion(elid);
			  //$("#modal_registrar_orden").modal("hide");
			  //$("#laordencompra").trigger("reset");
			  swal.closeModal();
			  $("#elshow").show();
			  $("#elformulario").hide();
			  $("#form_solicitudcotizacion").trigger("reset");
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

	//materiales ya fueron recibidos
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
              url:'../proyectos/cambiarestado/'+elid,
              type:'PUT',
              dataType:'json',
              data:{fecha_acta:'si',estado:8},
              success: function(json){
                if(json[0]==1){
                  informacion(elid);
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
	
	//modal para pausar
	$(document).on("click","#modal_pausar",function(e){
		e.preventDefault();
		$("#modal_pausar_proyecto").modal("show");
	});

	//pausar la ejecución de un proyecto
	$(document).on("click","#pausar_proyecto",function(e){
		var valid = $("#form_pausar").valid();
		if(valid){
			var datos=$("#form_pausar").serialize();
			modal_cargando();
			$.ajax({
				url:'../proyectos/cambiarestado/'+elid,
				type:'PUT',
				dataType:'json',
				data:datos,
				success: function(json){
				  if(json[0]==1){
					informacion(elid);
					toastr.success("Pausado con éxito");
					swal.closeModal();
					$("#modal_pausar_proyecto").modal("hide");
					$("#form_pausar").trigger("reset");
				  }else{
					toastr.error("Ocurrió un error");
					swal.closeModal();
				  }
				}, error: function(error){
					swal.closeModal();
				}
			  });
		}
	});

	//reanudar el proyecto
	$(document).on("click","#reanudar_proyecto",function(e){
		e.preventDefault();
		swal({
			title: '',
			text: "¿Está seguro de reanudar la ejecución del proyecto?",
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
				url:'../proyectos/cambiarestado/'+elid,
				type:'PUT',
				dataType:'json',
				data:{estado:8},
				success: function(json){
				  if(json[0]==1){
					informacion(elid);
					toastr.success("Reanudado con éxito");
				  }else{
					toastr.error("Ocurrió un error");
				  }
				}, error: function(error){
  
				}
			  });
			  swal(
				'¡Éxito!',
				'Éxito',
				'success'
			  );
			} else if (result.dismiss === swal.DismissReason.cancel) {
			  swal(
				'Nueva revisión',
				'Verifique los detalles del proyecto',
				'info'
			  );
			}
		  });
	});

	//filtrar por categorias en la solicitud
	$(document).on("change","#filtrar_categoria",function(e){
		var id=$(this).val();
		$.ajax({
			url:'../proyectos/presupuesto_categoria/'+id+'/'+elid,
			type:'GET',
			dataType:'json',
			success: function(json){
				if(json[0]==1){
					$("#cuerpo2").empty();
					$("#cuerpo2").html(json[3]);
				}
			}
		});
	});

	//funcion para los precios en la cotizacion
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
});

//Funcion para cargar los item de las categorias
function carga_item(){
	modal_cargando();
	$.ajax({
		url: '../categoria/listar',
		type: 'get',
		data: {
			id: $("#id-proy").val()
		},
		success: function (r) {
			swal.closeModal();
			$("#item").empty();
			$("#item").append('<option value="">Seleccione un ítem</option>');
			$(r).each(function (k, v) {
				var html = '<option value="' + v.id + '">' + v.item + ' ' + v.nombre_categoria + '</option>';
				$("#item").append(html);
				$("#item").trigger('chosen:updated');
			});
		},
		error: function(error){
			swal.closeModal();
			toastr.error("Ocurrió un error al cargar los datos");
		}
	});
}

function cargar_presupuesto(elid){
	modal_cargando();
	$.ajax({
		url:'../proyectos/elpresupuesto/'+elid,
		type:'get',
		dataType:'json',
		data:{},
		success: function(json){
			if(json[0]==1){
				$("#elpresu_aqui").empty();
				$("#elpresu_aqui").html(json[2]);
				$("#nueva_categoria").modal("hide");
				$("#cuerpito").empty();
				swal.closeModal();
				$("#descripcion_item").trigger("chosen:updated");
				$("#item").trigger("chosen:updated");
				//inicializar_tabla('example2');
			}else{
				swal.closeModal();
			}
		}
	});
}

function mostrar_solicitud(id)
  {
    modal_cargando();
      $.ajax({
        url:'../proyectos/versolicitud/'+id,
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

  //seleccionar una cotizacion
  function seleccionar(idcot,idproyecto)
  {
    var ruta ="../cotizaciones/seleccionar";
    $.ajax({
      url: ruta,
			type: 'POST',
			dataType: 'json',
			data:{idcot,idproyecto},
			success: function(data){
        console.log(data);
        if(data[0]== 1){
          toastr.success('Proveedor seleccionado con éxito');
		  mostrar_solicitud(data[2]);
		  informacion(elid);
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