$(document).ready(function(){
	var lafechaInicio;
	$('#calendario').fullCalendar({
	    dayClick: function(fecha, jsEvent){
	      $("#exampleModal").modal("show");
		  var fechaInicio = new Date(fecha);
			var anio=fechaInicio.getUTCFullYear();
			var mes =fechaInicio.getUTCMonth() + 1;
			var dia=fechaInicio.getUTCDate();
			lafechaInicio = anio + '-' + mes + '-' + dia;

		  console.log(anio,mes,dia);

	      /*$("#fecha").val(fecha.format());
	      var event = { id: 1  , title: 'Nuevo evento', start:  fecha};
	      $('#calendario').fullCalendar( 'renderEvent', event, true);*/
	    },
	    weekends: false,
	    editable: true,
	    lang:'es'
	  });
	  
	  $(document).on("click","#btnSubmit", function(event){
		  var valid=$("#add_evento").valid();
		  if(valid){
			var evento = $("#eventoId").val();
			var descripcion = $("#descripcion").val();

			
			$.ajax({
				method: 'GET',
				url: '/sisverapaz/public/AddCalendarizaciones',
				data: { evento: evento, descripcion: descripcion, updated_at: lafechaInicio, created_at: lafechaInicio  }
			}).then(function(json){

			});
		}
		
	});
});