$(document).ready(function(e){
	var eltoken = $('meta[name="csrf-token"]').attr('content');
	//cargar los modales
	$(document).on("click","#modal_categoria",function(e){
		$("#md_categoria").modal("show");
	});

	$(document).on("click","#create",function(e){
		$("#md_material").modal("show");
	});

	$(document).on("click","#agregar_medida",function(e){
		$("#md_medida").modal("show");
	})

	//ajax para guardar
	$(document).on("click","#registrar_categoria", function(e){
		var datos=$("#form_categoria").serialize();
		modal_cargando();
		$.ajax({
			url:'categorias',
			headers: {'X-CSRF-TOKEN':eltoken},
			type:'POST',
			dataType:'json',
			data:datos,
			success: function(json){
				if(json.mensaje=='exito'){
					location.reload();
				}else{
					swal.closeModal();
				}
			},error: function(error){
				console.log(error);
				$.each(error.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	});
	          	swal.closeModal();
			}
		});
	});

	$(document).on("click","#registrar_medida", function(e){
		var datos=$("#form_medida").serialize();
		modal_cargando();
		$.ajax({
			url:'unidadmedidas',
			headers: {'X-CSRF-TOKEN':eltoken},
			type:'POST',
			dataType:'json',
			data:datos,
			success: function(json){
				if(json.mensaje=='exito'){
					location.reload();
				}else{
					swal.closeModal();
				}
			},error: function(error){
				console.log(error);
				$.each(error.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	});
	          	swal.closeModal();
			}
		});
	});

	$(document).on("click","#registrar_material", function(e){
		var datos=$("#form_material").serialize();
		modal_cargando();
		$.ajax({
			url:'materiales',
			headers: {'X-CSRF-TOKEN':eltoken},
			type:'POST',
			dataType:'json',
			data:datos,
			success: function(json){
				if(json[0]==1){
					location.reload();
				}else{
					swal.closeModal();
				}
			},error: function(error){
				console.log(error);
				$.each(error.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	});
	          	swal.closeModal();
			}
		});
	});
});