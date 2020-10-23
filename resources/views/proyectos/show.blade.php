@extends('layouts.app')

@section('migasdepan')
<h1>&nbsp;</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Ver proyecto</li>
      </ol>
@endsection

@section('content')
<style>
	.subir{
		padding: 5px 10px;
		background: #f55d3e;
		color:#fff;
		border:0px solid #fff;
	}
	
	.skin-blue{
	  padding-right: 0px !important;
	}
	 
	.subir:hover{
		color:#fff;
		background: #f7cb15;
	}
	</style>
<div class="row" id="elshow">
	
	<div class="col-md-8">
		<div class="panel panel-primary" id="div_pre">
			<div class="panel-heading">Datos del Presupuesto </div>
			<div class="panel-body">
				@if($proyecto->presupuesto!="" )
				@if($proyecto->estado==1 || $proyecto->estado==2)
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nueva_categoria">Agregar Presupuesto</button>
				@endif
					@if($proyecto->presupuesto!="")
					<div id="elpresu_aqui"></div>
					@endif
					@include('proyectos.show.m_nueva_categoria')
				@else
					<center>
						<h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
						<span>Agregue un nuevo presupuesto para visualizar la información</span>
						<br><br>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nueva_categoria">Agregar Presupuesto</button>
						@include('proyectos.show.m_nueva_categoria')
					</center>
				@endif
					<a href="{{ url('proyectos/'.$proyecto->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
			</div>
					</div>
					
					<div class="panel panel-primary" id="div_ind" style="display: none">
			<div class="panel-heading">Datos de indicadores </div>
			<div class="panel-body" id="div_indicadores">
				@if($proyecto->indicadores->count() > 0)
					<ul class="todo-list" id="los_indicadores"></ul>
					@if($proyecto->indicadores->sum('porcentaje') < 100)
						<button type="button" id="add_indicador" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Agregar indicador</button>
					@endif
				@else
				<center>
					<h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
					<span>Agregue los nuevos indicadores para visualizar la información</span><br>
					<button type="button" id="add_indicador" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Agregar indicador</button>
				</center>
				@endif
			</div>
					</div>
					
		<div class="panel panel-primary" id="div_cot" style="display:none">
			<div class="panel-heading">Datos de las Solicitudes </div>
			<div class="panel-body" id="solicitud_aqui">
				
			</div>
		</div>
		<div class="panel panel-primary" id="div_contra" style="display:none">
			<div class="panel-heading">Datos de los contratos </div>
			<div class="panel-body" id="contrato_aqui">
				
			</div>
		</div>

		<div class="panel panel-primary" id="div_calen" style="display:none">
			<div class="panel-heading">Calendarización de las licitaciones </div>
			<div class="panel-body" id="calendarizaciones_aqui">
				
			</div>
		</div>
		<div class="panel panel-primary" id="div_lic" style="display:none">
			<div class="panel-heading">Listado de ofertas </div>
			<div class="panel-body" id="licitaciones_aqui">
				
			</div>
		</div>
		<div class="panel panel-primary" id="div_emple" style="display:none">
			<div class="panel-heading">Jornadas del proyecto</div>
			<div class="panel-body" id="jornadas_aqui">
				<div id="tabla_empleados"></div>
				<div style="display: none;" id="tabla_planilla"></div>
			</div>
			<div class="panel-body" id="jornada_form" style="display: none;">
				@include('proyectos.show.jornada')
			</div>
		</div>
		<div class="panel panel-primary" id="div_plani" style="display:none;">
			<div class="panel-heading">Empleados</div>
			<div class="panel-body">
				<div id="laplanilla">
					
					<div id="tabla_divempleados"></div>
				</div>
				<div id="plani_aqui" style="display: none;"></div>
			</div>
		</div>
		<div class="panel panel-primary" id="div_mapa" style="display:none;">
			<div class="panel-heading">Ubicación</div>
			<div class="panel-body">
				<div style="height: 500px;" id="elmapita"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-primary hidden-print">
				<div class="panel-heading">Opciones </div>
				<div class="panel-body">
					@if($proyecto->tipo_proyecto==1)
					<button type="button" class="btn btn-primary col-sm-12" id="btn_pre" style="margin-bottom: 3px;">
						Presupuesto
					</button>
					@else
					<button type="button" class="btn btn-default col-sm-12" id="btn_calen" style="margin-bottom: 3px;">
						Calendarización
					</button>
					<button type="button" class="btn btn-default col-sm-12" id="btn_lic" style="margin-bottom: 3px;">
							Ofertas
						</button>
					@endif
					<button type="button" class="btn btn-default col-sm-12" id="btn_ind" style="margin-bottom: 3px;">
						Indicadores
					</button>
					@if($proyecto->tipo_proyecto==1)
					<button type="button" class="btn btn-default col-sm-12" id="btn_cot" style="margin-bottom: 3px;">
						Solicitudes
					</button>
					
					<button type="button" class="btn btn-default col-sm-12" id="btn_emple" style="margin-bottom: 3px;">
						Pagos
					</button>
					<button type="button" class="btn btn-default col-sm-12" id="btn_plani" style="margin-bottom: 3px;">
						Empleados
					</button>
					@endif
					<button type="button" class="btn btn-default col-sm-12" id="btn_contra" style="margin-bottom: 3px;">
						Contratos
					</button>
					<button type="button" class="btn btn-default col-sm-12" id="btn_mapa" style="margin-bottom: 3px;">
						Ubicación
					</button>
				</div>
		</div>
		<div class="panel panel-primary hidden-print">
				<div class="panel-heading">Datos del Proyecto </div>
				<div class="panel-body" id="aqui_info">
					
				</div>
		</div>
	</div>
</div>
@if(isset($proyecto->presupuesto->presupuestodetalle))
<div class="row" id="elformulario" style="display: none;">
		
	</div>
@endif

<div id="modal_aqui"></div>
@include('proyectos.modales')
	@section('scripts')		
	<script>
		var elid='<?php echo $proyecto->id ?>';
		var eltipo='<?php echo $proyecto->tipo_proyecto ?>';
		var nombreproy='<?php echo $proyecto->nombre ?>';
		var lalat=parseFloat('<?php echo $proyecto->lat ?>');
		var lalng=parseFloat('<?php echo $proyecto->lng ?>');
		var marker;
		$(document).ready(function (){
			informacion(elid);
			verificar_tipo(eltipo);
			$('#btn_pre').click(function (){
				$("#div_pre").show();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
				$("#div_calen").hide();
				$("#div_emple").hide();
				$("#div_plani").hide();
				$("#div_mapa").hide();
		
				$("#btn_pre").removeClass('btn-default').addClass('btn-primary');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-default');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-default');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-default');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-default');
			});
		
			$("#btn_ind").click(function (){
				$("#div_pre").hide();
				$("#div_ind").show();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
				$("#div_calen").hide();
				$("#div_emple").hide();
				$("#div_plani").hide();
				$("#div_mapa").hide();
		
				$("#btn_ind").removeClass('btn-default').addClass('btn-primary');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-default');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-default');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-default');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-default');
				cargar_indicadores(elid);
			});
		
			$("#btn_cot").click(function (){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").show();
				$("#div_contra").hide();
				$("#div_lic").hide();
				$("#div_calen").hide();
				$("#div_emple").hide();
				$("#div_plani").hide();
				$("#div_mapa").hide();
		
				$("#btn_cot").removeClass('btn-default').addClass('btn-primary');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-default');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-default');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-default');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-default');
				solicitudes(elid);
			});

			$("#btn_contra").click(function (){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").show();
				$("#div_lic").hide();
				$("#div_calen").hide();
				$("#div_emple").hide();
				$("#div_plani").hide();
				$("#div_mapa").hide();
		
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-primary');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-default');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-default');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-default');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-default');
				contratos(elid);
			});

			$("#btn_lic").click(function (){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").show();
				$("#div_calen").hide();
				$("#div_emple").hide();
				$("#div_plani").hide();
				$("#div_mapa").hide();
		
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-primary');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-default');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-default');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-default');
				licitacion(elid);
			});

			$("#btn_emple").click(function(){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
				$("#div_calen").hide();
				$("#div_plani").hide();
				$("#div_emple").show();
				$("#div_mapa").hide();

				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-default');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-primary');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-default');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-default');
				pagos(elid);

			});

			$("#btn_plani").click(function(){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
				$("#div_calen").hide();
				$("#div_emple").hide();
				$("#div_plani").show();
				$("#div_mapa").hide();
				

				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-default');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-default');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-primary');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-default');
				empleados(elid);

			});

			$("#btn_calen").click(function(){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
				$("#div_calen").show();
				$("#div_emple").hide();
				$("#div_plani").hide();
				$("#div_mapa").hide();
				

				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-primary');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-default');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-default');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-default');
				calendario(elid);
			});

			$("#btn_mapa").click(function(){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
				$("#div_calen").hide();
				$("#div_emple").hide();
				$("#div_plani").hide();
				$("#div_mapa").show();
				

				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_mapa").removeClass('btn-primary').addClass('btn-primary');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-default');
				$("#btn_emple").removeClass('btn-primary').addClass('btn-default');
				$("#btn_plani").removeClass('btn-primary').addClass('btn-default');
				initMap(lalat,lalng);
			});


			//abrir el modal para registrar el evento
			$(document).on("click","#add_evento",function(e){
				e.preventDefault();
				$("#modal_evento").modal("show");
			});

			//registrar el calendario
			

			$(document).on("click","#registrar_evento",function(e){
				e.preventDefault();
				var datos=$("#form_evento").serialize();
				datos=datos+'&proyecto_id='+elid;
				modal_cargando();
				$.ajax({
					url:'../calendarizaciones',
					type:'post',
					dataType:'json',
					data:datos,
					success: function(json){
						if(json[0]==1){
							toastr.success("Evento registrado con éxito");
							$("#form_evento").trigger("reset");
							$("#modal_evento").modal("hide");
							swal.closeModal();
							calendario(elid);
						}else{
							toastr.error("Ocurrió un error");
							swal.closeModal();
						}
					},
					error: function(error){
						swal.closeModal();
					}
				});
			});

		//imprimir calendadario
		$(document).on("click","#printcal",function(e){
			e.preventDefault();
			window.print();  
		});

		$(document).on("click","#subir_bases",function(e){
			e.preventDefault();
			$("#modal_subir_base").modal("show");
		});

		});
		function verificar_tipo(eltipito)
		{
			if(eltipito==2){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
				$("#div_calen").show();
		
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				$("#btn_calen").removeClass('btn-primary').addClass('btn-primary');
				calendario(elid);
			}
		}

		function cargar_indicadores(elid){
			modal_cargando();
			porcentaje=0.0;
			var html="";
			$.ajax({
				url:'../indicadores/segunproyecto/'+elid,
				type:'GET',
				dataType:'json',
				data:{elid},
				success: function(json){
					if(json[0]==1){
						porcentaje=parseFloat(json[4]);
						$("#div_indicadores").empty();
						$("#div_indicadores").append(json[3]);
						swal.closeModal();
					}else{
						swal.closeModal();
					}
				},error:function(error){
					console.log(error);
					swal.closeModal();
				}	
			});
		}

		function informacion(elid){
			$.ajax({
				url:'../proyectos/informacion/'+elid,
				type:'get',
				data:{},
				dataType:'json',
				success: function(json){
					if(json[0]==1){
						$("#aqui_info").empty();
						$("#aqui_info").html(json[2]);
					}
				}
			});
		}

		function solicitudes(elid){
			$.ajax({
				url:'../proyectos/solicitudes/'+elid,
				type:'get',
				data:{},
				dataType:'json',
				success: function(json){
					if(json[0]==1){
						$("#solicitud_aqui").empty();
						$("#solicitud_aqui").html(json[2]);
					}
				}
			});
		}

		function contratos(elid){
			$.ajax({
				url:'../proyectos/contratos/'+elid,
				type:'get',
				data:{},
				dataType:'json',
				success: function(json){
					if(json[0]==1){
						$("#contrato_aqui").empty();
						$("#contrato_aqui").html(json[2]);
					}
				}
			});
		}

		function licitacion(id){
			modal_cargando();
			$.ajax({
				url:'../proyectos/licitaciones/'+id,
				type:'get',
				dataType:'json',
				success: function(json){
					if(json[0]==1){
						swal.closeModal();
						$("#licitaciones_aqui").empty();
						$("#licitaciones_aqui").html(json[2]);
						//inicializar_tabla("estatabla");
					}else{
						toastr.error("Ocurrió un error al cargar la información");
						swal.closeModal();
					}
				},
				error: function(error){
					toastr.error("Ocurrió un error al cargar la información");
					swal.closeModal();
				}
			});
		}

		function calendario(id){
			modal_cargando();
			$.ajax({
				url:'../proyectos/calendario/'+id,
				type:'get',
				dataType:'json',
				success: function(json){
					if(json[0]==1){
						swal.closeModal();
						console.log(json[3])
						$("#calendarizaciones_aqui").empty();
						$("#calendarizaciones_aqui").html(json[2]);
						//inicializar_tabla("calender");
						$('#calendario').fullCalendar({
							header: {
								left:   'month,agendaWeek,agendaDay',
								center: 'title',
								right:  'today prev,next'
							},
							events:json[3],
							eventColor: '#D51C38',
							weekends: false,
							//defaultView: 'agendaDay',
							//defaultView: 'timeline', // the name of a generic view
							editable: false,
							lang:'es',
							
							eventClick: function(info) {
								console.log(info);
								alert(info.title);
							}
						});
					}else{
						swal.closeModal();
					}
				},
				error: function(error){
					swal.closeModal();
				}
			});
		}

		function pagos(elid){
			$.ajax({
				url:'../proyectos/pagos/'+elid,
				type:'get',
				data:{},
				dataType:'json',
				success: function(json){
					if(json[0]==1){
						$("#tabla_empleados").empty();
						$("#tabla_empleados").html(json[2]);
						inicializar_tabla("latabla");
					}
				}
			});
		}

		function empleados(elid){
			$.ajax({
				url:'../proyectos/empleados/'+elid,
				type:'get',
				data:{},
				dataType:'json',
				success: function(json){
					if(json[0]==1){
						$("#tabla_divempleados").empty();
						$("#tabla_divempleados").html(json[2]);
						inicializar_tabla("latabla2");
					}
				}
			});
		}

		function initMap(lalat,lalng) {
			console.log(lalat,lalng);
			var map;
			
			map = new google.maps.Map(document.getElementById('elmapita'), {
			center: {lat: lalat, lng: lalng},
			zoom: 15,   
			});

			marker = new google.maps.Marker({
				position: {lat: lalat, lng: lalng},
				map: map,
				title: nombreproy,
				icon: '../img/obrero.png', // Path al nuevo icono,
				draggable: true,
			});

			marker.addListener('click', toggleBounce);
			

			marker.addListener( 'dragend', function (event)
			{
				//escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
				var lat = this.getPosition().lat();
				var lng = this.getPosition().lng();
				$.ajax({
					url:'../proyectos/cambiarubicacion',
					type:'post',
					dataType:'json',
					data:{proyecto_id:elid,lat,lng},
					success: function(json){
						if(json[0]==1){
							marker.setAnimation(null);
							initMap(lat,lng);
							toastr.success("Ubicación actualizada");
						}else{
							toastr.error("Ocurrió un error");
						}
					},
					error: function(error){
						toastr.error("Ocurrió un error");
					}
				});
			});
		}

			function toggleBounce() {
				if (marker.getAnimation() !== null) {
					marker.setAnimation(null);
				} else {
					marker.setAnimation(google.maps.Animation.BOUNCE);
				}
			}

	</script>
	@if($proyecto->presupuesto!="")
		<?php $unavariable=$proyecto->presupuesto->id; ?>
	@else
	<?php $unavariable=0; ?>
	@endif
	{!! Html::script('js/presupuestoR.js?cod='.date('yidisus')) !!}
	{!! Html::script('js/indicadores.js?cod='.date('yidisus')) !!}
	{!! Html::script('js/proyecto_show.js?cod='.date('yidisus')) !!}
	<script>
		var elid='<?php echo $proyecto->id ?>';
		var preid='<?php  echo $unavariable ?>';
	</script>
	@endsection
@endsection