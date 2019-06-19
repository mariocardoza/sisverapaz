$(document).ready(function(e){
	$(document).on("click","#btn_guardar",function(e){
		var datos=$("#empleado_form").serialize();
		console.log(datos);
		var ruta = "../empleados";
		var token = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
	      	url: ruta,
	      	headers: {'X-CSRF-TOKEN':token},
	      	type:'POST',
	      	dataType:'json',
	      	data:datos,

	      	success: function(json){
	      		if(json[0]==1){
	      			toastr.success('exito');
	      			window.location.href = "../empleados";
	      		}else{
	      			toastr.error('error');
	      		}
	      		console.log(json);
	        	
	        
	      	},
	      	error : function(data){
	          	$.each(data.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	})
	        }
	    });
	});
});