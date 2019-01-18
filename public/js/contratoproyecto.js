$(document).ready(function(){
	cargarEmpleados();
	cargarCargo();

	$(document).on("click","#guardar_proy", function(e){
		var datos = $("#form_proy").serialize();
		console.log("esto "+datos );
	});

	$('#guardarempleado').on("click", function(e){
		var nombre = $("#nom_empleado").val();
		var dui = $("#dui_empleado").val();
		var nit = $("#nit_empleado").val();
		var telefono = $("#tel_empleado").val();
		var celular = $("#cel_empleado").val();
		var direccion = $("#direc_empleado").val();
		var nacimiento = $("#nacimiento_empleado")
		var cuenta = $("#num_cuenta").val();
		var seguro = $("num_seguro").val();
		var afp = $("num_afp").val();
		alert(sexo);
		var ruta ="/"+carpeta()+"/public/contratoproyectos/guardarempleado";
		var token = $('meta[name="csrf-token"]').attr('content');

		$.ajax({
			url: ruta,
			headers: {'X-CSRF-TOKEN':token},
			type: 'POST',
			dataType: 'json',
			data:{nombre,dui,nit,sexo,telefono,celular,direccion,nacimiento,cuenta,seguro,afp},

			success: function(){
				toastr.success('Empleado Registrado');
				cargarEmpleados();
			},
			error: function(data, textStatus, errorThrown){
				toastr.error('Ha ocurrido un '+textStatus+' en la solicitud');
				$.each(data.responseJSON.errors, function( key, value) {
					toastr.error(value);
				});
			}
		});
	});

	$('#guardartipo').on("click", function(e){
		var nombre = $("#nombre_tipo").val();
		var ruta = "/"+carpeta()+"/public/contratoproyectos/guardartipo";
		var token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			url: ruta,
			headers: {'X-CSRF-TOKEN':token},
			type:'POST',
			dataType:'json',
			data:{nombre:nombre},

			success: function(){
				toastr.success('Contrato creado');
				cargarTipo();
			},error : function(data){
				toastr.error(data.responseJSON.errors.nombre);
			}
		});
	});

	$('#guardarcargo').on("click", function(e){
		var cargo = $("#cargo_nombre").val();
		var ruta = "/"+carpeta()+"/public/contratos/guardarcargo";
		var token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			url: ruta,
			headers: {'X-CSRF-TOKEN':token},
			type:'POST',
			dataType:'json',
			data:{cargo:cargo},

			success: function(){
				toastr.success('Cargo creado');
				$("#cargo_nombre").val("");
				cargarCargo();
			},
			error:function(data){
				toastr.error(data.responseJSON.errors.cargo);
			}
		});
	});
});

function cargarEmpleados(){
	$.get('/'+carpeta()+'/public/contratoproyectos/listarempleados', function(data){
		var html_select = '<option value="">Seleccione un empleado</option>';
		for(var i=0;i<data.length;i++){
			html_select +='<option value="'+data[i].id+'">'+data[i].nombre+'</option>'
			$("#empleado").html(html_select);
		}
	});
}

function cargarTipo(){
	//$.get('/'+carpeta()+'/public/contratoproyectos/listartipos')
}

function cargarCargo(){
	$.get('/'+carpeta()+'/public/contratoproyectos/listarcargos', function (data){
		var html_select = '<option value="">Seleccione un cargo</option>';
		for(var i=0;i<data.length;i++){
			html_select +='<option value="'+data[i].id+'">'+data[i].cargo+'</option>'
			$("#cargo").html(html_select);
		}
	});
}
