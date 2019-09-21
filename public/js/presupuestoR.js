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
						var html = '<option data-nombre="'+v.nombre+'" data-uninom="'+v.nombre_medida+'" data-unidad="' + v.idunidad + '" value="' + v.id + '">' + v.nombre + ' - '+ v.nombre_medida + '</option>';
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
		var unidad = $("#descripcion_item option:selected").data('uninom');

		var select = $("#descripcion_item");

		var tabla = $("#tabla_detalle");

		var html = '<tr data-medida="' + id_desc + '" data-cantidad="' + cantidad + '" data-precio="' + precio + '">' +
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
				var html = '<option data-nombre="'+v.nombre+'" data-uninom="'+v.nombre_medida+'" data-unidad="' + v.idunidad + '" value="' + v.id + '">' + v.nombre + ' - ' +v.nombre_medida+'</option>';
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
					precio: $(element).attr("data-precio")
				});
			}
		});
		console.log(presupuestos);

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
					precio: $(element).attr("data-precio")
				});
			}
		});
		//console.log(presupuestos);

		/////////////////////////////////////////////////// funcion ajax para editar ///////////////////////////////////////////////////////////////////
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
				} else {
					console.log(json);
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
	$(document).on("click","#modal_soli",function(e){
		e.preventDefault();
		$("#elshow").hide();
		$("#elformulario").show();
	});
	$(document).on("click","#cancelar_soli",function(e){
		e.preventDefault();
		$("#elshow").show();
		$("#elformulario").hide();
		$("#form_solicitudcotizacion").trigger("reset");
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
			  cantidad:$(this).attr("data-cantidad")
			});
		  }
		});
  
		// if(requi.length==0){
		  //swal('aviso','Seleccione los ítems','warning');
		//}else{
		  $.ajax({
			url:'../solicitudcotizaciones',
			type:'post',
			data:{formapago,encargado,cargo,proyecto,unidad,lugar_entrega,fecha_limite,tiempo_entrega,presu},
			success: function(response){
			  if(response.mensaje=='exito'){
				toastr.success('Solicitud registrada exitosamente');
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