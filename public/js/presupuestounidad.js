$(document).ready(function(){
	$(document).on("click","#add_material", function(e){
		listarmateriales(id_presupuesto);
		$("#modal_detalle").modal("show");
	});

	$(document).on("click","#esteagrega", function(e){
		var td=$(this).parents("tr").children('td:eq(4)');
		var material=$(this).attr("data-material");
		var unidad=$(this).attr('data-unidad');
		var nombre=$(this).attr('data-nombre');
		var id=$(".elid").val();
		$("#nom_material").text(nombre);
		$("#id_mat").val(material);
		$("#elpresuid").val(id_presupuesto);
		$("#modal_detalle").modal("hide");
		$("#modal_registrar_material").modal("show");
	  });

	  $(document).on("click","#registrar_presupuesto",function(e){
		var valid=$("#form_material").valid();
		if(valid){
			modal_cargando();
			var datos=$("#form_material").serialize();
			$.ajax({
				url:'../presupuestounidaddetalles',
				type:'POST',
				data:datos,
				success: function(json){
					if(json[0]==1){
						toastr.success("Ítem registrado exitosamente");
						window.location.reload();
					}else{
						toastr.error("Ocurrió un error");
						swal.closeModal();
					}
				},error: function(error){
					swal.closeModal();
				}
			})
		}
	  });

	  $(document).on("click","#eleditar",function(e){
		var id=$(this).attr("data-id");
		$.ajax({
			url:'../presupuestounidaddetalles/'+id+"/edit",
			type:'GET',
			dataType:'json',
			data:{},
			success: function(json){
				if(json[0]==1){
					$("#modal_aqui").empty();
					$("#modal_aqui").html(json[2]);
					$("#modal_editar_material").modal("show");
				}else{

				}
			}
		});
	  });

	  $(document).on("click","#editar_presupuesto",function(e){
		  e.preventDefault();
		  var id=$("#elpresuid_edit").val();
		  var datos=$("#form_edit_material").serialize();
		  var valid=$("#form_edit_material").valid();
		  if(valid){
			  modal_cargando();
			  $.ajax({
				  url:'../presupuestounidaddetalles/'+id,
				  type:'PUT',
				  data:datos,
				  success: function(json){
					if(json[0]==1){
						toastr.success("Editado exisamente");
						location.reload();
					}else{
						swal.closeModal();
						toastr.error("Ocurrió un error");
					}
				  }
			  });
		  }
	  });

	  $(document).on("click","#eleliminar",function(e){
		var id=$(this).attr('data-id');
        swal({
            title: 'Eliminar',
            text: "¿Está seguro de eliminar este ítem?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si!',
            cancelButtonText: '¡No!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
              $.ajax({
                url:'../presupuestounidaddetalles/'+id,
                type:'DELETE',
                dataType:'json',
                data:{},
                success: function(json){
                  if(json[0]==1){
                    location.reload();
                    toastr.success("Eliminado con exito");
                  }else{
                    toastr.error("Ocurrió un error");
                  }
                }, error: function(error){
  
                }
              });
			}
			
	  });
	});

	//cambiar estado al presupuesto
	$(document).on("click",".estado",function(e){
		var id=$(this).attr("data-id");
		var estado=$(this).attr("data-estado");
		swal({
            title: '',
            text: "¿Está seguro de realizar esta acción?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si!',
            cancelButtonText: '¡No!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
              $.ajax({
                url:'../presupuestounidades/cambiar/'+id,
                type:'POST',
                dataType:'json',
                data:{estado},
                success: function(json){
                  if(json[0]==1){
                    location.reload();
                    toastr.success("Realizado con éxito");
                  }else{
                    toastr.error("Ocurrió un error");
                  }
                }, error: function(error){
  
                }
              });
			}
	  	});
	});
});

function listarmateriales(id)
{
	modal_cargando();
  $.ajax({
	url:'../presupuestounidades/materiales/'+id,
	type:'get',
	data:{},
	success:function(data){
	  if(data[0]==1){
		$("#losmateriales").empty();
		//console.log(latabla);
		//latabla.clear();
		$("#losmateriales").html(data[2]);
		var latabla=inicializar_tabla("latabla");
		var valor = 0;
		swal.closeModal();
		/**$("#latabla tbody tr").each(function(){
		  console.log($(this).find('td:eq(1)').text());
		  latabla.row.add([
			$(this).find('td:eq(0)').text(),
			$(this).find('td:eq(1)').text(),
			$(this).find('td:eq(2)').text(),
			$(this).find('td:eq(3)').text(),
			$(this).find('td:eq(4)').text()
			]);
		});
		latabla.draw();*/
		//console.log(data);
		
		//latabla.destroy();

	  }else{
		  swal.closeModal();
	  }
	}
  });
}
