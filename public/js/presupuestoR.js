$(document).ready(function () {
	var catalogo_original = [];
	var catalogo_en_uso = [];
	var catalogo_original_index = [];
	var total = 0;
	carga_item();

	$("#item").on('change',function () { 
		var id = $("#item").val();
		var select = $("#descripcion_item");
		if (id != "") {
			$.get('../presupuestos/getcatalogo/' + id, function (data) {
				select.empty();
				select.append('<option value="">Seleccione una descripción</option>');
				catalogo_original = [];
				catalogo_original_index = [];
				$(data).each(function (k, v) { 
					catalogo_original.push(v);
					catalogo_original_index.push(v.id);
					var html = '<option data-unidad="' + v.unidad_id + '" value="' + v.id + '">' + v.nombre + '</option>';
					select.append(html);
				});
				select.trigger('chosen:updated');
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
		var descripcion = $("#descripcion_item option:selected").text();
		var id_desc = $("#descripcion_item").val();
		var cantidad = $("#cantidad").val();
		var precio = $("#precio").val();
		var unidad = $("#descripcion_item option:selected").data('unidad');

		var select = $("#descripcion_item");

		var tabla = $("#tabla_detalle");

		var html = '<tr data-catalogo="' + id_desc + '" data-cantidad="' + cantidad + '" data-precio="' + precio + '">' +
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

		catalogo_en_uso.push(parseInt(id_desc));

		select.empty();
		select.append('<option value="">Seleccione una descripción</option>');
		$(catalogo_original).each(function (k, v) { 
			if (catalogo_en_uso.indexOf(catalogo_original_index[k]) == -1) {
				var html = '<option data-unidad="' + v.unidad_medida + '" value="' + v.id + '">' + v.nombre + '</option>';
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
		$("#tabla_detalle body tr").each(function (index, element) {
			if (element) {
				presupuestos.push({
					catalogo: $(element).attr("data-catalogo"),
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
			data: { proyecto_id, categoria_id, total, presupuestos },
			success: function (msj) {
				if (msj.mensaje == 'exito') {
					window.location.href = "../proyectos";
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
			}
		});
	});

	//Funcion para cargar los item de las categorias
	function carga_item(){
		$.ajax({
			url: '../categoria/listar',
			type: 'get',
			data: {
				id: $("#id-proy").val()
			},
			success: function (r) {
				$("#item").empty();
				$("#item").append('<option value="">Seleccione un ítem</option>');
				$(r).each(function (k, v) {
					var html = '<option value="' + v.id + '">' + v.item + ' ' + v.nombre_categoria + '</option>';
					$("#item").append(html);
					$("#item").trigger('chosen:updated');
				});
			}
		});
	}
});