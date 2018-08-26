$(document).ready(function(){
	var tbRequisicion = $("#tbRequisicion");
	$("#agregar").on("click",function(e){
		e.preventDefault();
		cant = $("#cantidad").val() || 0;
		unidad = $("#unidad_medida option:selected").text() || 0;
		descripcion = $("#descripcion").val() || 0;

		if(cant && unidad && descripcion){
			if(cant <= 0){
				swal(
					 '¡Aviso!',
					 'El campo de cantidad debe ser mayor a 0',
					 'warning')
			}else{
				$(tbRequisicion).append(//$() Para hacer referencia
					"<tr data-descripcion='"+descripcion+"' data-cantidad='"+cant+"' data-unidad='"+unidad+"'>"+
					"<td>"+descripcion+"</td>"+
					"<td>"+cant+"</td>"+
					"<td>"+unidad+"</td>"+
					"<td>" +
					"<button type='button' class='btn btn-danger btn-xs' id='eliminar'><span class='glyphicon glyphicon-remove'></span></button></td>" +
					"</tr>"
				);
				limpiar();
			}
		}else{
			swal(
				 '¡Aviso!',
				 'Debe llenar todos los campos',
				 'warning')
		}
	});

	$("#proyecto").on("change", function(){
		var id = $(this).val();
		//alert(id);
	});

	$("#btnguardar").on("click", function(){
		var token = $('meta[name="csrf-token"]').attr('content');
		var actividad = $("#actividad").val();
		var user_id = $("#user_id").val();
		var observaciones = $("#observaciones").val();
		var requisiciones = new Array();
		$(cuerpo).find("tr").each(function (index, element) {
				if(element){
						requisiciones.push({
								descripcion: $(element).attr("data-descripcion"),
								cantidad :$(element).attr("data-cantidad"),
								unidad : $(element).attr("data-unidad")
						});
				}
		});
	//	console.log(unidad_admin);

/////////////////////////////////////////////////// funcion ajax para guardar ///////////////////////////////////////////////////////////////////
			$.ajax({
					url: "../requisiciones",
					headers: {'X-CSRF-TOKEN':token},
					type:'POST',
					data: {actividad,user_id,observaciones,requisiciones},
				 success : function(msj){
					 console.log(msj);
						if(msj.mensaje == 'exito'){
							window.location.href = "../requisiciones";
							console.log(msj);
							toastr.success('Requisiciones registrada éxitosamente');
						}else{
							toastr.error('Ocurrió un error, contacte al administrador');
						}

					},
					error: function(data, textStatus, errorThrown){
							$.each(data.responseJSON.errors, function( key, value ) {
									toastr.error(value);
					});
					}
	});
});

	$(document).on("click","#eliminar",function(e){
		var tr= $(e.target).parents("tr");
		tr.remove();
	});

	function limpiar(){
		$("#requisicion").find("#cantidad, #descripcion, #unidad_medida").each(function(index, element){
			$(element).val("");
			$("#unidad_medida").trigger('chosen:updated');
		});
	}
});
