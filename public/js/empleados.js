$(document).ready(function(e){
	var eltoken = $('meta[name="csrf-token"]').attr('content');
	$(document).on("click","#btn_guardar",function(e){
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
	      			window.location.href = "../empleados";
	      		}else{
	      			toastr.error('error');
	      		}
	      		console.log(json);
	        	
	        
	      	},
	      	error : function(data){
	          	$.each(data.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	})
	        }
	    });
	});

// para imagenes
	$(document).on("click", "#img_file", function (e) {
        $("#file_1").click();
    });

    $(document).on("change", "#file_1", function(event) {
        validar_archivo($(this));
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
			})
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
              }


         };
          Lector.onerror = function(e) {
          console.log(e)
         }
         Lector.readAsDataURL(Archivos[0]);
  }
}