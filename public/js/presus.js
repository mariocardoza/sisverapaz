$(document).ready(function(e){
    //boton de agregar material
    listarmateriales(id_presupuesto);
    inicio();

    $(document).on("click","#registrar", function(e){
        e.preventDefault();
        $("#elpresupuesto").hide();
        $("#panel_registrar").show();
        listarmateriales(id_presupuesto);
    });

    $(document).on("click","#cancelar_guardar,#cancelar_editar",function(e){
        e.preventDefault();
        $("#elpresupuesto").show();
        $("#panel_registrar").hide();
        $("#panel_editar").hide();
        $("#form_presupuesto_edit").trigger("reset");
    });

    $(document).on("click","#add_material",function(e){
        e.preventDefault();
        listarmateriales(id_presupuesto);
    });

    $(document).on("click","#guardar", function(e){
        e.preventDefault();
        material = $("#elmaterial").val() || 0,
        enero = $("#ene").val() || 0,
        febrero = $("#feb").val() || 0,
        marzo = $("#mar").val() || 0,
        abril = $("#abr").val() || 0,
        mayo = $("#may").val() || 0,
        junio = $("#jun").val() || 0,
        julio = $("#jul").val() || 0,
        agosto = $("#ago").val() || 0,
        septiembre = $("#sep").val() || 0,
        octubre = $("#oct").val() || 0,
        noviembre = $("#nov").val() || 0,
        diciembre = $("#dic").val() || 0;
        var cantidad = parseInt(enero) + parseInt(febrero) + parseInt(marzo) + parseInt(abril) + parseInt(mayo) + parseInt(junio) + parseInt(julio) + parseInt(agosto) + parseInt(septiembre) + parseInt(octubre) + parseInt(noviembre) + parseInt(diciembre);
        if(material>0){
            if(cantidad>0){
                var datos=$("#form_presupuesto").serialize();
                datos+'&cantidad='+cantidad;
                $.ajax({
                    url:'../presupuestounidaddetalles',
                    type:'post',
                    dataType:'json',
                    data:datos+'&cantidad='+cantidad+'&precio=0',
                    success: function(json){
                        if(json[0]==1){
                            toastr.success('Material registrado con éxito');
                            $("#elpresupuesto").show();
                            $("#panel_registrar").hide();
                            inicio();
                            $("#form_presupuesto").trigger("reset");
                        }
                    }
                })
            }else{
                swal(
                    '¡Aviso!',
                    'Debe agregar al menos una cantidad',
                    'warning'
                );
            }
        }else{
            swal(
                '¡Aviso!',
                'Debe llenar todos los campos',
                'warning'
            );
        }
    });

    $(document).on("click","#eliminar",function(e){
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
                    inicio();
                    $("#elpresupuesto").show();
                    $("#panel_registrar").hide();
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

    $(document).on("click","#eleditar",function(e){
        var id=$(this).attr("data-id");
        modal_cargando();
        $.ajax({
            url:'../presupuestounidaddetalles/'+id+"/edit",
            type:'get',
            dataType:'json',
            data:{},
            success: function(json){
                if(json[0]==1){
                    $("#form_aqui").empty();
                    $("#form_aqui").html(json[2]);
                    $("#panel_editar").show();
                    $("#elpresupuesto").hide();
                    $("#panel_registrar").hide();
                    swal.closeModal();
                }else{
                    swal.closeModal();
                }
            },error: function(e){
                swal.closeModal();
            }
        })
    });

    $(document).on("click","#editar", function(e){
        e.preventDefault();
        id=$("#ideditar").val();
        enero = $("#e_ene").val() || 0,
        febrero = $("#e_feb").val() || 0,
        marzo = $("#e_mar").val() || 0,
        abril = $("#e_abr").val() || 0,
        mayo = $("#e_may").val() || 0,
        junio = $("#e_jun").val() || 0,
        julio = $("#e_jul").val() || 0,
        agosto = $("#e_ago").val() || 0,
        septiembre = $("#e_sep").val() || 0,
        octubre = $("#e_oct").val() || 0,
        noviembre = $("#e_nov").val() || 0,
        diciembre = $("#e_dic").val() || 0;
        var cantidad = parseInt(enero) + parseInt(febrero) + parseInt(marzo) + parseInt(abril) + parseInt(mayo) + parseInt(junio) + parseInt(julio) + parseInt(agosto) + parseInt(septiembre) + parseInt(octubre) + parseInt(noviembre) + parseInt(diciembre);
        if(enero){
           
            modal_cargando();
            $.ajax({
                url:'../presupuestounidaddetalles/'+id,
                type:'PUT',
                dataType:'json',
                data:{presupuestounidad_id:id_presupuesto,cantidad,enero,febrero,marzo,abril,mayo, junio, julio,agosto,septiembre,octubre,noviembre,diciembre},
                success: function(json){
                    if(json[0]==1){
                        toastr.success("Información actualizada con éxito");
                        inicio();
                        $("#elpresupuesto").show();
                        $("#panel_editar").hide();
                        swal.closeModal();
                        $("#form_presupuesto_edit").trigger("reset");
                    }else{
                        swal.closeModal();
                        toastr.error("Error");
                    }
                }
            })
        }else{
            swal(
                '¡Aviso!',
                'Debe llenar todos los campos',
                'warning'
            );
        }
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
          $("#aqui_select").empty();
          $("#aqui_select").html(data[4]);
          $(".chosen").chosen({'width':'100%'});
		//$("#losmateriales").empty();
		//console.log(latabla);
		//latabla.clear();
		//$("#losmateriales").html(data[2]);
		//var latabla=inicializar_tablac("presu");
		//var valor = 0;
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

function inicio(){
    modal_cargando();
    $.ajax({
        url:'../api/presupuestounidades/show2/'+id_presupuesto,
        type:'get',
        dataType:'json',
        data:{},
        success: function(json){
            if(json[0]==1){
                swal.closeModal();
                $("#elpresupuesto").empty();
                $("#elpresupuesto").html(json[2]);
            }else{
                swal.closeModal();
            }
        }
    });
}