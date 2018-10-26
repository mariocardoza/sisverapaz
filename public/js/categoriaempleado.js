$(document).ready(function(){
	listarempleados();
	listarcategoriatrabajos();
	listarcargos();
});

function listarempleados()
{
	var html = '<option value=""> Seleccione un empleado </option>';
	$.ajax({
		url:'../empleados',
		type:'get',
		data:[],
		success:function(data)
		{
			console.log(data);
			$.each(data,function(index,valores){
				html+='<option value="'+valores.id+'">'+valores.nombre+'</option>'
			});
			$('#empleado').html(html);
		},
		error:function(error)
		{

		}
	});
}

function listarcategoriatrabajos()
{
	var trabajo = '<option value=""> Seleccione categoría de trabajo </option>';
	$.ajax({
		url:'../categoriatrabajos',
		type:'get',
		data:[],
		success:function(data)
		{
			console.log(data);
			$.each(data, function(index,valores){
				trabajo+='<option value="'+valores.id+'">'+valores.nombre_categoria+'</option>'
			});
			$('#categoriatrabajo').html(trabajo);
		},
		error:function(error)
		{

		}
	});
}

function listarcargos()
{
	var cargo = '<option value=""> Seleccione cargo </option>';
	$.ajax({
		url:'../cargos',
		type:'get',
		data:[],
		success:function(data)
		{
			$.each(data, function(index,valores){
				cargo+='<option value="'+valores.id+'">'+valores.cargo+'</option>'
			});
			$('#cargo').html(cargo);
		},
		error:function(error)
		{

		}
	});
}