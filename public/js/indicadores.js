var porcentaje=0.0;
var token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(e){
	cargar_indicadores();
	$(document).on("click","#add_indicador",function(e){
		$("#modal_indicador").modal("show");
	});

	$(document).on("click","#agregar_indicador", function(e){
		var nombre=$("#nombre_indicador").val() || 0;
		var descripcion=$("#descripcion_indicador").val() || 0;
		var porcen=parseFloat($("#porcentaje_indicador").val());
		var valid = $("#losdatos").valid();
		if(valid){
			porcentaje=porcentaje+porcen;
			if(porcentaje>100){
				swal('Aviso','Sobrepasa el 100%','warning');
				cargar_indicadores();
			}else{
				$.ajax({
					url:'../indicadores',
					type:'POST',
					headers: {'X-CSRF-TOKEN':token},
					dataType:'json',
					data:{nombre,descripcion,porcen,elproyecto},
					success: function(json){
						if(json[0]==1){
							toastr.success("Agregado con éxito");
							cargar_indicadores();
						}else{
							toastr.error("Ocurrió un error");
						}
					},error:function(error){

					}
				});
            //$("#los_indicadores").append(html);
            $("#modal_indicador").modal("hide");
			}
			
		}
		/*if(nombre && descripcion && porcentaje){

		}else{
			swal('aviso','Digite las opciones','warning');
		}*/
	});

	$(document).on("click","#editar_indicador",function(e){
		var codigo=$(this).attr("data-id");
		alert(codigo);
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
					cargar_indicadores();
					toastr.success("Eliminado exitosamente");
				}else{
					toastr.error("Ocurrió un error, contacte al administrador");
				}
			},error: function(json){

			}
		})
	});


	jQuery.extend(jQuery.validator.messages, {
      required: "Este campo es obligatorio.",
      remote: "Por favor, rellena este campo.",
      email: "Por favor, escribe una dirección de correo válida",
      url: "Por favor, escribe una URL válida.",
      date: "Por favor, escribe una fecha válida.",
      dateISO: "Por favor, escribe una fecha (ISO) válida.",
      number: "Por favor, escribe un número entero válido.",
      digits: "Por favor, escribe sólo dígitos.",
      creditcard: "Por favor, escribe un número de tarjeta válido.",
      equalTo: "Por favor, escribe el mismo valor de nuevo.",
      accept: "Por favor, escribe un valor con una extensión aceptada.",
      maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
      minlength: jQuery.validator.format("Por favor, digita al menos {0} caracteres."),
      rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
      range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
      max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
      min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });
});

function cargar_indicadores(){
	porcentaje=0.0;
	var html="";
	$.ajax({
		url:'../indicadores/segunproyecto/'+elproyecto,
		type:'GET',
		headers: {'X-CSRF-TOKEN':token},
		dataType:'json',
		data:{elproyecto},
		success: function(json){
			if(json[0]==1){
				$(json[2]).each(function(index,value){
					porcentaje+=value.porcentaje;
					html+='<li>'+
                            '<span class="handle">'+
                                '<i class="fa fa-ellipsis-v"></i>'+
                              '</span>'+
                          '<input type="checkbox" value="">'+
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
			}
		},error:function(error){
			console.log(error);
		}	
	});
}