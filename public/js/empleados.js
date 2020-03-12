$(document).ready(function(e){
	var eltoken = $('meta[name="csrf-token"]').attr('content');
	$(document).on("click","#btn_guardar",function(e){
		e.preventDefault();
		var valor=$("#nit_empleado").val();
		var fecha=$("#fecha_nacimiento").val();
		if(valor!='' && fecha != ''){
			var partes=valor.split("-");
		
			var nuevo=partes[1][0]+partes[1][1]+"-"+partes[1][2]+partes[1][3]+"-"+partes[1][4]+partes[1][5];
			
			var fechan=fecha[0]+fecha[1]+"-"+fecha[3]+fecha[4]+"-"+fecha[8]+fecha[9];		
		
			if(nuevo === fechan){
				var datos=$("#empleado_form").serialize();
				console.log(datos);
				var ruta = "../empleados";
				var token = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					url: ruta,
					headers: {'X-CSRF-TOKEN':token},
					type:'POST',
					dataType:'json',
					data:datos,

					success: function(json){
						if(json[0]==1){
							toastr.success('exito');
							window.location.href = "../empleados/"+json[2].id;
						}else{
							toastr.error('error');
						}
						console.log(json);
						
					
					},
					error : function(data){
						$.each(data.responseJSON.errors,function(index,value){
							toastr.error(value);
						});
					}
				});
			}else{
				toastr.error("La fecha de nacimiento no coincide según el número de NIT");
			}
		}else{
			toastr.error("Complete todos los campos obligatorios");
		}
	});

// para imagenes
	$(document).on("click", "#img_file", function (e) {
        $("#file_1").click();
    });

    $(document).on("change", "#file_1", function(event) {
        validar_archivo($(this));
	});
	
	//input del NIT
	$(document).on("blur","#nit_empleado",function(e){
		e.preventDefault();
		
	});

	//select para el tipo de planilla
	$(document).on("change","#select_tipo",function(e){
		var tipo=$(this).val();
		//alert(tipo);
		if(tipo!=''){
			if(tipo=='2'){
				$(".elproy").show();
				$("#select_proy").removeAttr("disabled");
				$("#select_proy").trigger("chosen:updated");
				$("#select_cargo").prop('disabled', 'disabled');
				$("#select_cargo").trigger("chosen:updated");
				$("#select_unidad").prop('disabled', 'disabled');
				$("#select_unidad").trigger("chosen:updated");
			}else{
				$(".elproy").hide();
				$("#select_proy").trigger("chosen:updated");
				$("#select_proy").prop('disabled', 'disabled');
				$("#select_cargo").removeAttr("disabled");
				$("#select_cargo").trigger("chosen:updated");
				$("#select_unidad").removeAttr("disabled");
				$("#select_unidad").trigger("chosen:updated");
			}
		}else{
			$(".elproy").hide();
			$("#select_proy").trigger("chosen:updated");
			$("#select_proy").prop('disabled', 'disabled');
			$("#select_cargo").removeAttr("disabled");
			$("#select_cargo").trigger("chosen:updated");
			$("#select_unidad").removeAttr("disabled");
			$("#select_unidad").trigger("chosen:updated");
		}
	});

	//*** Editar el contrato *****/
	$(Document).on("click","#formedit_contrato",function(e){
		var id=$(this).attr('data-id');
		var tipo=$(this).attr("data-tipo");
		if(tipo==2){
			$(".elproy").show();
			$("#select_proy").removeAttr("disabled");
			$("#select_proy").trigger("chosen:updated");
			$("#select_cargo").prop('disabled', 'disabled');
			$("#select_cargo").trigger("chosen:updated");
			$("#select_unidad").prop('disabled', 'disabled');
			$("#select_unidad").trigger("chosen:updated");
		}else{
			$(".elproy").hide();
			$("#select_proy").trigger("chosen:updated");
			$("#select_proy").prop('disabled', 'disabled');
			$("#select_cargo").removeAttr("disabled");
			$("#select_cargo").trigger("chosen:updated");
			$("#select_unidad").removeAttr("disabled");
			$("#select_unidad").trigger("chosen:updated");
		}

		$("#btn_editarcontrato").attr("data-id",id);
		e.preventDefault();
		$("#info_contra").hide();
		$("#edi_contrato").show();

	});

	$(document).on("click","#btn_cancelarcontrato",function(e){
		e.preventDefault();
		$("#info_contra").show();
		$("#edi_contrato").hide();
	});

	$(document).on("click","#btn_editarcontrato",function(e){
		e.preventDefault();
		var id=$(this).attr('data-id');
		var datos=$("#form_editcontra").serialize();
		$.ajax({
			url:'../detalleplanillas/'+id,
			type:'put',
			dataType:'json',
			data:datos,
			success: function(json){
			if(json[0]==1){
				toastr.success("Contrato registrado con exito");
				window.location.reload();
			}else{
				toastr.error("Ocurrió un error");
				swal.closeModal();
			}
			}, error: function(error){
				$.each(error.responseJSON.errors,function(index,value){
					  toastr.error(value);
				  });
				  swal.closeModal();
			}
		});
	});

	$(document).on("click","#btn_editar",function(e){
		var datos=$("#e_empleados").serialize();
		if(window.location.pathname=='/sisverapaz/public/empleados'){
			var ruta='empleados/'+elempleado;
		}else{
			var ruta = "../empleados/"+elempleado;
		}
		modal_cargando();
		
		var token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
	      	url: ruta,
	      	headers: {'X-CSRF-TOKEN':token},
	      	type:'PUT',
	      	dataType:'json',
	      	data:datos,

	      	success: function(json){
	      		if(json[0]==1){
	      			toastr.success('exito');
	      			window.location.reload();
	      		}else{
	      			toastr.error('error');
	      			swal.closeModal();
	      		}
	      		console.log(json);
	        	
	        
	      	},
	      	error : function(data){
	      		console.log(data);
	          	$.each(data.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	});
	          	swal.closeModal();
	        }
	    });
	});

	$(document).on("click","#modal_banco",function(e){
		e.preventDefault();
		$("#modal_bancarios").modal("show");
	});

	$(document).on("click","#modal_afps",function(e){
		e.preventDefault();
		$("#modal_afp").modal("show");
	});

	$(document).on("click","#modal_usuarios",function(e){
		e.preventDefault();
		$("#modal_user").modal("show");
	});

	$(document).on("click","#modal_prestamo",function(e){
		e.preventDefault();
		$("#md_prestamo").modal("show");
	});

	$(document).on("click","#modal_descuento",function(e){
		e.preventDefault();
		$("#md_descuento").modal("show");
	});

	$(document).on("click","#editar_usuario",function(e){
		e.preventDefault();
		$("#editar_user").modal("show");
	});

	$(document).on("click","#modal_isss",function(e){
		e.preventDefault();
		$("#modales_isss").modal("show");
	});

	$(document).on("click","#modal_editar",function(e){
		e.preventDefault();
		$("#modal_edit").modal("show");
	});

	$(document).on("click","#modal_para_editar",function(e){
		e.preventDefault();
		$("#modal_edit").modal("show");
	});

	

	$(document).on("click","#registrar_bancarios", function(e){
		var valid=$("#bancarios").valid();
		if(valid){
			modal_cargando();
			var datos=$("#bancarios").serialize();
			$.ajax({
				url:'../empleados/bancarios',
				headers: {'X-CSRF-TOKEN':eltoken},
				type:'POST',
				dataType:'json',
				data:datos,
				success: function(json){
					if(json[0]==1){
					toastr.success("Dato de AFP registrados con éxito");
					window.location.reload();
					}else{
						toastr.error("Ocurrió un error");
						swal.closeModal();
					}
				}, error: function(error){
					$.each(error.responseJSON.errors,function(index,value){
	          			toastr.error(value);
	          		});
	          		swal.closeModal();
				}
			})
		}
	});

	$(document).on("click","#regi_prestamo", function(e){
		var valid=$("#form_prestamo").valid();
		//if(valid){
			modal_cargando();
			var datos=$("#form_prestamo").serialize();
			$.ajax({
				url:'../prestamos',
				headers: {'X-CSRF-TOKEN':eltoken},
				type:'POST',
				dataType:'json',
				data:datos,
				success: function(json){
					if(json[0]==1){
					toastr.success("El préstamo se registro con éxito");
					window.location.reload();
					}else{
						toastr.error("Ocurrió un error");
						swal.closeModal();
					}
				}, error: function(error){
					$.each(error.responseJSON.errors,function(index,value){
	          			toastr.error(value);
	          		});
	          		swal.closeModal();
				}
			})
		//}
	});

	$(document).on("click","#regi_descuento", function(e){
		var valid=$("#form_descuento").valid();
		//if(valid){
			modal_cargando();
			var datos=$("#form_descuento").serialize();
			$.ajax({
				url:'../descuentos',
				headers: {'X-CSRF-TOKEN':eltoken},
				type:'POST',
				dataType:'json',
				data:datos,
				success: function(json){
					if(json[0]==1){
					toastr.success("El descuento se registro con éxito");
					window.location.reload();
					}else{
						toastr.error("Ocurrió un error");
						swal.closeModal();
					}
				}, error: function(error){
					$.each(error.responseJSON.errors,function(index,value){
	          			toastr.error(value);
	          		});
	          		swal.closeModal();
				}
			})
		//}
	});

	$(document).on("click",".que_ver",function(e){
		e.preventDefault();
		var opcion=$(this).attr("data-opcion");
		if(opcion==1){
			$("#general").hide();
			$("#descuentos").hide();
			$("#contrato").show();
		}else if(opcion==2){
			$("#general").show();
			$("#descuentos").hide();
			$("#contrato").hide();
		}else if(opcion==3){
			$("#general").hide();
			$("#descuentos").show();
			$("#contrato").hide();
		}
	});

	$(document).on("click","#btn_guardarcontrato", function(e){
		modal_cargando();
			var datos=$("#form_planilla").serialize();
			$.ajax({
				url:'../detalleplanillas',
				headers: {'X-CSRF-TOKEN':eltoken},
				type:'POST',
				dataType:'json',
				data:datos,
				success: function(json){
				if(json[0]==1){
					toastr.success("Contrato registrado con exito");
					window.location.reload();
				}else{
					toastr.error("Ocurrió un error");
					swal.closeModal();
				}
				}, error: function(error){
					$.each(error.responseJSON.errors,function(index,value){
	          			toastr.error(value);
	          		});
	          		swal.closeModal();
				}
			});
	});

	$(document).on("click","#registrar_afp", function(e){
		var valid=$("#afps").valid();
		if(valid){
			modal_cargando();
			var datos=$("#afps").serialize();
			$.ajax({
				url:'../empleados/afps',
				headers: {'X-CSRF-TOKEN':eltoken},
				type:'POST',
				dataType:'json',
				data:datos,
				success: function(json){
				if(json[0]==1){
					toastr.success("Dato de AFP registrados con éxito");
					window.location.reload();
				}else{
					toastr.error("Ocurrió un error");
					swal.closeModal();
				}
				}, error: function(error){
					$.each(error.responseJSON.errors,function(index,value){
	          			toastr.error(value);
	          		});
	          		swal.closeModal();
				}
			});
		}
	});

	$(document).on("click","#registrar_isss", function(e){
		var valid=$("#isss").valid();
		if(valid){
			var datos=$("#isss").serialize();
			$.ajax({
				url:'../empleados/isss',
				headers: {'X-CSRF-TOKEN':eltoken},
				type:'POST',
				dataType:'json',
				data:datos,
				success: function(json){
				if(json[0]==1){
					toastr.success("Dato de AFP registrados con éxito");
					window.location.reload();
				}else{
					toastr.error("Ocurrió un error");
				}
				}, error: function(error){
					$.each(error.responseJSON.errors,function(index,value){
	          			toastr.error(value);
	          		});
				}
			})
		}
	});

	$(document).on("click","#eledit_user", function(e){
		var valid=$("#e_usuarios").valid();
		if(valid){
			modal_cargando();
			var datos=$("#e_usuarios").serialize();
			$.ajax({
				url:'../empleados/eusuarios',
				headers: {'X-CSRF-TOKEN':eltoken},
				type:'POST',
				dataType:'json',
				data:datos,
				success: function(json){
					if(json[0]==1){
					toastr.success("Dato de usuario actualizados con éxito");
					window.location.reload();
					}else{
						toastr.error("Ocurrió un error");
						swal.closeModal();
					}
				}, error: function(error){
					$.each(error.responseJSON.errors,function(index,value){
	          			toastr.error(value);
	          		});
	          		swal.closeModal();
				}
			})
		}
	});

	$(document).on("click","#registrar_user", function(e){
		var valid=$("#n_usuario").valid();
		if(valid){
			modal_cargando();
			var datos=$("#n_usuario").serialize();
			$.ajax({
				url:'../empleados/usuarios',
				headers: {'X-CSRF-TOKEN':eltoken},
				type:'POST',
				dataType:'json',
				data:datos,
				success: function(json){
					if(json[0]==1){
					toastr.success("Dato de usuario registrados con éxito");
					window.location.reload();
					}else{
						toastr.error("Ocurrió un error");
						swal.closeModal();
					}
				}, error: function(error){
					$.each(error.responseJSON.errors,function(index,value){
	          			toastr.error(value);
	          		});
	          		swal.closeModal();
				}
			})
		}
	});

	$(document).on("click","#dar_baja",function(e){
		swal({
		  title: '¿Desea eliminar el empleado?',
		  type: 'question',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  cancelButtonText: 'No',
		  confirmButtonText: 'Si'
		}).then((result) => {
		  if (result.value) {
		    $.ajax({
		    	url:'../empleados/'+elempleado,
		    	type:'DELETE',
		    	dataType:'json',
		    	data:{},
		    	headers: {'X-CSRF-TOKEN':eltoken},
		    	success: function(json){
		    		console.log(json);
		    		if(json[0]==1){
		    			toastr.success("El empleado se eliminó exitosamente");
		    			window.location.href='../empleados';
		    		}
		    	}, error: function(error){
		    		console.log(error);
		    	}
		    });
		  }
		});
	});

	//select de los categorias de los empleados
	$(document).on("change","#select_catcargo",function(e){
		e.preventDefault()
		var id=$(this).val();
		$.ajax({
			url:'../empleados/selectcargos/'+id,
			type:'get',
			dataType:'json',
			success: function(json){
				if(json[0]==1){
					$("#select_cargo").empty();
					$("#select_cargo").html(json[2]);
					$("#select_cargo").chosen({'width':'100%'});
					$("#select_cargo").trigger("chosen:updated");
				}
			}
		});
	});
});


function validar_archivo(file){
  $("#img_file").attr("src","../img/photo.svg");//31.gif
      //var ext = file.value.match(/\.(.+)$/)[1];
       //Para navegadores antiguos
       if (typeof FileReader !== "function") {
          $("#img_file").attr("src",'../img/photo.svg');
          return;
       }
       var Lector;
       var Archivos = file[0].files;
       var archivo = file;
       var archivo2 = file.val();
       if (Archivos.length > 0) {

          Lector = new FileReader();

          Lector.onloadend = function(e) {
              var origen, tipo, tamanio;
              //Envia la imagen a la pantalla
              origen = e.target; //objeto FileReader
              //Prepara la información sobre la imagen
              tipo = archivo2.substring(archivo2.lastIndexOf("."));
              console.log(tipo);
              tamanio = e.total / 1024;
              console.log(tamanio);

              //Si el tipo de archivo es válido lo muestra, 

              //sino muestra un mensaje 

              if (tipo !== ".jpeg" && tipo !== ".JPEG" && tipo !== ".jpg" && tipo !== ".JPG" && tipo !== ".png" && tipo !== ".PNG") {
                  $("#img_file").attr("src",'../img/photo.svg');
                  $("#error_formato1").removeClass('hidden');
                  //$("#error_tamanio"+n).hide();
                  //$("#error_formato"+n).show();
                  console.log("error_tipo");
              }
              else{
                  $("#img_file").attr("src",origen.result);
                  $("#error_formato1").addClass('hidden');
                  $("#elquecambia").css("display","block");
              }


         };
          Lector.onerror = function(e) {
          console.log(e)
         }
         Lector.readAsDataURL(Archivos[0]);
  }
}

