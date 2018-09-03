var token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(e){
  listarformapagos();

$('input[name="seleccionar"]').on('click', function(e) {
    idcot = (this.value);
    idproy = $(this).attr('data-proyecto');
		swal({
			title: '¿Está seguro?',
			text: "¿Desea seleccionar este proveedor?",
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
				swal(
					'¡Seleccionado!',
					'Proveedor seleccionado.',
					'success'
				)
        seleccionar(idcot,idproy);
			} else if (result.dismiss === swal.DismissReason.cancel) {
				swal(
					'Cancelado',
					'Seleccione un proveedor',
					'info'
				)
				$('input[name=seleccionar]').attr('checked',false);
			}
		})
});

$('input[name="seleccionarr"]').on('click', function(e) {
    idcot = (this.value);
    idrequisicion = $(this).attr('data-requisicion');
		swal({
			title: '¿Está seguro?',
			text: "¿Desea seleccionar este proveedor?",
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
				swal(
					'¡Seleccionado!',
					'Proveedor seleccionado.',
					'success'
				)
        seleccionarr(idcot,idrequisicion);
			} else if (result.dismiss === swal.DismissReason.cancel) {
				swal(
					'Cancelado',
					'Seleccione un proveedor',
					'info'
				)
				$('input[name=seleccionarr]').attr('checked',false);
			}
		})
});


	$("#proyecto").on("change",  function(e){
		var id = (this.value);
		if(id > 0){
			var datos = $.get('/'+carpeta()+'/public/solicitudcotizaciones/getpresupuesto/'+ id , function(data){
		        //var dataJson = JSON.stringify({ id: data[i].fondocat.id, monto: data[i].monto })
		  			$(cuerpo).empty();
		  			$(data).each(function(key, value){
		  				$(cuerpo).append(
			                "<tr>"+
			                    "<td>" + value.catalogo.nombre + "</td>" +
			                    "<td>" + value.catalogo.unidad_medida + "</td>" +
			                    "<td>" + value.cantidad + "</td>" +
			                    "<td><input type='text' name='marcas[]' class='form-control' /></td>" +
			                    "<td><input type='number' name='precios[]' steps='any' required class='precios form-control' />"+
			                    "<input type='hidden' name='unidades[]' value='"+value.catalogo.unidad_medida+"'/>"+
			                    "<input type='hidden' name='descripciones[]' value='"+value.catalogo.nombre+"'/>"+
			                    "<input type='hidden' name='cantidades[]' value='"+value.cantidad+"'/>"+
			                    "</td>"+
			                    "<td class='total'>$0.00</td>"+
			                "</tr>"
			          	);
		  			});
	    	});
		}else {
			swal(
			'Debe seleccionar un proyecto!',
			'',
			'info'
		);
		$(cuerpo).empty();
		}

	});

  $(".precios").keyup(function(e){
    var element = $(e.currentTarget),
      cantidad   = $(element).attr('data-cantidad'),
      subTotal =  $(element).val(),
      parent  = element.parents("tr");

      if($.isNumeric($(element).val()) && $.trim($(element).val()))
  			subTotal = ( $(element).val() * parseFloat(cantidad) );
  		else
  			subTotal = 0
      //console.log(parent);
      $(parent).find(".subtotal").text("$"+subTotal.toFixed(2));
  });

  $("#btnguardar").on("click", function(e){
    var marcas = new Array();
    var precios = new Array();
    var unidades = new Array();
    var descripciones = new Array();
    var cantidades = new Array();
    $('input[name^="marcas"]').each(function() {
      marcas.push($(this).val());
    });

    $('input[name^="precios"]').each(function() {
      precios.push($(this).val());
    });

    $('input[name^="unidades"]').each(function() {
      unidades.push($(this).val());
    });

    $('input[name^="descripciones"]').each(function() {
      descripciones.push($(this).val());
    });

    $('input[name^="cantidades"]').each(function() {
      cantidades.push($(this).val());
    });

    var proveedor = $("#proveedor").val();
    var descripcion = $("#formapago").val();
    var id = $("#id").val();

    $.ajax({
      url:'../../cotizaciones',
      headers: {'X-CSRF-TOKEN':token},
      type:'post',
      data:{id,proveedor,descripcion,marcas,precios,cantidades,unidades,descripciones},
      success: function(response){
        if(response.mensaje=='exito'){
          toastr.success("Cotización registrada exitosamente");
          if(response.tipo == 1){
            location.href="../../solicitudcotizaciones/versolicitudes/"+response.proyecto;
          }else{
            location.href="../../requisiciones";
          }
        }else{
          toastr.error("Debe llenar todos los campos de precio unitario");
          console.log(response);
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

  function seleccionar(id,idproy)
  {
    var ruta ="/"+carpeta()+"/public/cotizaciones/seleccionar";
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: ruta,
			headers: {'X-CSRF-TOKEN':token},
			type: 'POST',
			dataType: 'json',
			data:{idcot,idproy},

			success: function(data){
        console.log(data);
        if(data.mensaje === 'exito'){
          toastr.success('Proveedor seleccionado con éxito');
          console.log(data);
          window.location.href = "/"+carpeta()+"/public/solicitudcotizaciones/versolicitudes/"+data.id;
        }else{
          toastr.error('Ha ocurrido un error en la solucitud contacte al administrador');
          console.log(data.mensaje);
        }

			},
			error: function(data, textStatus, errorThrown){
        console.log(data);
				toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
				$.each(data.responseJSON.errors, function( key, value ) {
					toastr.error(value);
			});
			}
    });
  }

  function seleccionarr(id,idrequisicion)
  {
    var ruta ="../../cotizaciones/seleccionarr";
    $.ajax({
      url: ruta,
			headers: {'X-CSRF-TOKEN':token},
			type: 'POST',
			data:{idcot,idrequisicion},

			success: function(data){
        console.log(data);
        if(data.mensaje === 'exito'){
          toastr.success('Proveedor seleccionado con éxito');
          window.location.href = "../../requisiciones";
        }else{
          toastr.error('Ha ocurrido un error en la solucitud contacte al administrador');
          console.log(data.mensaje);
        }

			},
			error: function(data, textStatus, errorThrown){
        console.log(data);
				toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
				$.each(data.responseJSON.errors, function( key, value ) {
					toastr.error(value);
			});
			}
    });
  }

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

  function listarformapagos()
  {
  	$.ajax({
  		url:'../../formapagos',
  		type:'get',
  		data:{},
  		success:function(data){
  			var html_select = '<option value="">Seleccione una forma de pago</option>';
  				$(data).each(function(key, value){
  					html_select +='<option value="'+value.nombre+'">'+value.nombre+'</option>'
  					//console.log(data[i]);
  					$("#formapago").html(html_select);
  					$("#formapago").trigger('chosen:updated');
  				});
  				//console.log(data);
  		}
  	});
  }
});
