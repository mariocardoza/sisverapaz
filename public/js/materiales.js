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
				if(json[0]==1){
					location.reload();
					toastr.success("Unidad de medida registrada con éxito");
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

	//modal para editar
	$(document).on("click","#modal_edit",function(e){
		modal_cargando();
		var id=$(this).attr("data-id");
		$.ajax({
			url:'materiales/modaleditar/'+id,
			type:'get',
			dataType:'json',
			success: function(json){
				swal.closeModal();
				if(json[0]==1){
					$("#aqui_modal").empty(); //es un div que tiene qui modal en el index
					$("#aqui_modal").html(json[2]); //Trae todo para el dom
					$("#md_material_edit").modal("show");
					$(".chosen-select-width").chosen({
						'width':'100%'
					});//para convertir el selct y darle estilo
				}else{

				}
			},error: function(error){
				swal.closeModal();
			}
		})
	});

	$(document).on("click","#editar_material",function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		var datos=$("#form_ematerial").serialize();
		modal_cargando();
		$.ajax({
			url:'materiales/'+id,
			type:'PUT',
			data:datos,
			dataType:'json',
			success: function(json){
				if(json[0]==1){
					location.reload();
					toastr.success("Editado con éxito");
				}else{
					swal.closeModal();
					toastr.error("Ocurrió un error");
				}
			}, error: function(error){
				$.each(error.responseJSON.errors,function(index,value){
					toastr.error(value);
				});
				swal.closeModal();
			}
		})
	});
});