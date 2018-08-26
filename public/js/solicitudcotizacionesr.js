var token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){
	listarformapagos();
	listarunidades();

	$("#btnguardar").on("click", function(e){
		var formapago = $("#formapago").val();
		var encargado = $("#encargado").val();
		var cargo = $("#cargo").val();
		var requisicion = $("#requisicion").val();
		var unidad = $("#unidad").val();
		var lugar_entrega = $("#lugar_entrega").val();
		var fecha_limite = $("#fecha_limite").val();
		var tiempo_entrega = $("#tiempo_entrega").val();

		$.ajax({
			url:'../../solicitudcotizaciones/storer',
			headers: {'X-CSRF-TOKEN':token},
			type:'post',
			data:{formapago,encargado,cargo,requisicion,unidad,lugar_entrega,fecha_limite,tiempo_entrega},
			success: function(response){
				if(response.mensaje=='exito'){
					toastr.success('Solicitud registrada exitosamente');
					location.href ="../../requisiciones";
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

	$("#guardarformapago").on("click", function(e){
		var nombre = $("#nombre").val();

		$.ajax({
			url:'../../formapagos',
			headers: {'X-CSRF-TOKEN':token},
			type:'post',
			data:{nombre},
			success: function(response){
				if(response=='exito'){
					toastr.success('Forma de pago registrada exitosamente');
					listarformapagos();
					$("#modalformapago").modal("hide");
				}
			},
			error: function(error){
				$.each(error.responseJSON.errors, function( key, value ) {
					toastr.error(value);
				});
			}
		});
	});

	$("#guardarunidad").on("click", function(e){
		var nombre_unidad = $("#nombre_unidad").val();

		$.ajax({
			url:'../../unidades',
			headers: {'X-CSRF-TOKEN':token},
			type:'post',
			data:{nombre_unidad},
			success: function(response){
				if(response=='exito'){
					$("#modalunidad").modal("hide");
					listarunidades();
					toastr.success('Unidad administrativa registrada exitosamente');
				}
			},
			error: function(error){
				$.each(error.responseJSON.errors, function( key, value ) {
					toastr.error(value);
				});
			}
		});
	});

function listarformapagos()
{
	$.ajax({
		url:'../../formapagos',
		type:'get',
		data:{},
		success:function(data){
			var html_select = '<option value="">Seleccione una forma de pago</option>';
				$(data).each(function(key, value){
					html_select +='<option value="'+value.id+'">'+value.nombre+'</option>'
					//console.log(data[i]);
					$("#formapago").html(html_select);
					$("#formapago").trigger('chosen:updated');
				});
		}
	});
}

function listarunidades()
{
	$.ajax({
		url:'../../unidades',
		type:'get',
		data:{},
		success:function(data){
			var html_select = '<option value="">Seleccione una unidad administrativa</option>';
				$(data).each(function(key, value){
					html_select +='<option value="'+value.id+'">'+value.nombre_unidad+'</option>'
					//console.log(data[i]);
					$("#unidad").html(html_select);
					$("#unidad").trigger('chosen:updated');
				});
		}
	});
}

});
