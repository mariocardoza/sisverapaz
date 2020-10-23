var porcentaje=0.0;
var token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(e){
	//cargar_indicadorese();
	$(document).on("click","#add_indicador",function(e){
		$("#modal_indicador").modal("show");
	});

	$(document).on("click","#agregar_indicador", function(e){
		var nombre=$("#nombre_indicador").val() || 0;
		var descripcion=$("#descripcion_indicador").val() || 0;
		var porcen=parseFloat($("#porcentaje_indicador").val());
		var valid = $("#form_indicador").valid();
		if(valid){
			porcentaje=porcentaje+porcen;
			if(porcentaje>100){
				swal('Aviso','Sobrepasa el 100%','warning');
				toastr.info("Sobrepasa el 100%");
				cargar_indicadores(elid);
				$("#form_indicador").trigger("updated");
			}else{
				modal_cargando();
				$.ajax({
					url:'../indicadores',
					type:'POST',
					dataType:'json',
					data:{nombre,descripcion,porcen,elproyecto:elid},
					success: function(json){
						if(json[0]==1){
							toastr.success("Agregado con éxito");
							cargar_indicadores(elid);
							$("#form_indicador").trigger("reset");
							swal.closeModal();
							$("#modal_indicador").modal("hide");
						}else{
							toastr.error("Ocurrió un error");
							swal.closeModal();
						}
					},error:function(error){
						swal.closeModal();
					}
				});
            //$("#los_indicadores").append(html);
            
			}
			
		}
		/*if(nombre && descripcion && porcentaje){

		}else{
			swal('aviso','Digite las opciones','warning');
		}*/
	});

	$(document).on("click","#agregar_indicador_e", function(e){
		var nombre=$("#nombre_indicador_e").val() || 0;
		var elcodigo=$("#elcodigo_e").val() || 0;
		//alert(elcodigo);
		var descripcion=$("#descripcion_indicador_e").val() || 0;
		var porcen=parseFloat($("#porcentaje_indicador_e").val());
		var valid = $("#losdatos_e").valid();
		if(valid){
			//porcentaje=porcentaje+porcen;
			if(porcentaje>100){
				swal('Aviso','Sobrepasa el 100%','warning');
				cargar_indicadores();
			}else{
				modal_cargando();
				$.ajax({
					url:'../indicadores/'+elcodigo,
					type:'PUT',
					dataType:'json',
					data:{nombre,descripcion,porcen,elproyecto:elid},
					success: function(json){
						if(json[0]==1){
							toastr.success("Agregado con éxito");
							cargar_indicadores(elid);
							$("#modal_indicador_e").modal("hide");
							swal.closeModal();
						}else{
							toastr.error("Ocurrió un error");
							swal.closeModal();
						}
					},error:function(error){
						swal.closeModal();
					}
				});
            //$("#los_indicadores").append(html);
            
			}
			
		}
		/*if(nombre && descripcion && porcentaje){

		}else{
			swal('aviso','Digite las opciones','warning');
		}*/
	});

	$(document).on("click","#editar_indicador",function(e){
		var codigo=$(this).attr("data-id");
		$.ajax({
			url:'../indicadores/'+codigo+'/edit',
			type:'GET',
			dataType:'json',
			data:{},
			success: function(json){
				if(json[0]==1){
					console.log(json);
					$("#nombre_indicador_e").val(json[2].nombre);
					$("#descripcion_indicador_e").val(json[2].descripcion);
					$("#porcentaje_indicador_e").val(json[2].porcentaje);
					$("#elcodigo_e").val(json[2].id);
					$("#modal_aqui").html(json[2]);
					$("#modal_indicador_e").modal("show");
				}
			},error: function(error){
				console.log(error);
			}
		});
	});

	$(document).on("click","#eliminar_indicador",function(e){
		var codigo=$(this).attr("data-id");
		$.ajax({
			url:'../indicadores/'+codigo,
			type:'DELETE',
			headers: {'X-CSRF-TOKEN':token},
			dataType:'json',
			data:codigo,
			success: function(json){
				if(json[0]==1){
					cargar_indicadores(elid);
					toastr.success("Eliminado exitosamente");
				}else{
					toastr.error("Ocurrió un error, contacte al administrador");
				}
			},error: function(json){

			}
		})
	});


	///completar un indicadir///
	$(document).on("click","#indicador_completado",function(e){
		id=$(this).attr("data-id");
		swal({
		  title: '¿El indicador se completó?',
		  type: 'question',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  cancelButtonText: 'No',
		  confirmButtonText: 'Si'
		}).then((result) => {
		  if (result.value) {
		    $.ajax({
		    	url:'../indicadores/completado',
		    	type:'POST',
		    	dataType:'json',
		    	data:{id:id},
		    	headers: {'X-CSRF-TOKEN':token},
		    	success: function(json){
		    		console.log(json);
		    		if(json[0]==1){
		    			toastr.success("El indicador se completó exitosamente");
		    			cargar_indicadores(elid);
		    			informacion(elid);
		    		}
		    	}, error: function(error){
		    		console.log(error);
		    	}
		    });
		  }
		});
	});


});

function cargar_indicadorese(elid){
	modal_cargando();
	porcentaje=0.0;
	var html="";
	$.ajax({
		url:'../indicadores/segunproyecto/'+elid,
		type:'GET',
		headers: {'X-CSRF-TOKEN':token},
		dataType:'json',
		data:{elid},
		success: function(json){
			if(json[0]==1){
				$(json[2]).each(function(index,value){
					var laclase="";
					if(value.estado==2){
						laclase='done';
					}
					porcentaje+=value.porcentaje;
					html+='<li class="'+laclase+'">'+
                            '<span class="handle">'+
                                '<i class="fa fa-ellipsis-v"></i>'+
                              '</span>'+
                          '<input type="checkbox" data-id="'+value.codigo+'" id="indicador_completado" value="">'+
                          '<span class="text">'+value.nombre+'</span>'+
                          '<small class="label label-danger"><i class="glyphicon glyphicon-ok"></i> '+value.porcentaje+' %</small>'+
                          '<div class="tools">'+
                            '<i data-id="'+value.codigo+'" id="editar_indicador" class="fa fa-edit"></i>'+
                            '<i data-id="'+value.codigo+'" id="eliminar_indicador" class="fa fa-trash-o"></i>'+
                          '</div>'+
                        '</li>';
				});
				$("#los_indicadores").empty();
				$("#los_indicadores").append(html);
				swal.closeModal();
			}else{
				swal.closeModal();
			}
		},error:function(error){
			console.log(error);
			swal.closeModal();
		}	
	});
}