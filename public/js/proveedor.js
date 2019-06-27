$(document).ready(function(e){
	var eltoken = $('meta[name="csrf-token"]').attr('content');
	$(document).on("click","#show_representante",function(e){
		e.preventDefault();
		$("#modal_representante").modal("show");
	});
	$(document).on("click","#editar",function(e){
		e.preventDefault();
		$("#modal_proveedor").modal("show");
	});
	

	$(document).on("click","#registrar_representante", function(e){
		var datos=$("#form_representante").serialize();
		$.ajax({
			url:'../proveedores/representante/'+elproveedor,
			headers: {'X-CSRF-TOKEN':eltoken},
			type:'POST',
			dataType:'json',
			data:datos,
			success: function(json){
				if(json[0]==1){
					toastr.success('exito');
	      			window.location.reload();
				}else{
					toastr.error("Ocurrió un error");
				}
			}, error: function(error){
				toastr.error("Ocurrió un error");
			}
		});
	});

	$(document).on("click","#editar_proveedor", function(e){
		var datos=$("#form_proveedor").serialize();
		modal_cargando()
			var ruta = "../proveedores/"+elproveedor;
		
		$.ajax({
			url:ruta,
			headers: {'X-CSRF-TOKEN':eltoken},
			type:'PUT',
			dataType:'json',
			data:datos,
			success: function(json){
				if(json[0]==1){
					toastr.success('exito');
	      			window.location.reload();
	      			console.log(json);
				}else{
					toastr.error("Ocurrió un error");
					swal.closeModal();
				}
			}, error: function(error){
				$.each(data.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	});
	          	swal.closeModal();
			}
		});
	});
});