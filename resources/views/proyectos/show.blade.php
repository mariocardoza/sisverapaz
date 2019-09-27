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
<div class="container">
    <div class="row" id="elshow">
        <div class="col-md-7">
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
						<center>
							<h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
							<span>Agregue un nuevo contrato para visualizar la información</span>
						</center>
					</div>
				</div>
				<div class="panel panel-primary" id="div_lic" style="display:none">
						<div class="panel-heading">Licitaciones </div>
						<div class="panel-body" id="licitaciones_aqui">
							<center>
								<h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
								<span>Agregue una nueva licitación para visualizar la información</span>
							</center>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-primary">
							<div class="panel-heading">Opciones </div>
							<div class="panel-body">
								@if($proyecto->tipo_proyecto==1)
								<button type="button" class="btn btn-primary col-sm-12" id="btn_pre" style="margin-bottom: 3px;">
									Presupuesto
								</button>
								@else
								<button type="button" class="btn btn-default col-sm-12" id="btn_lic" style="margin-bottom: 3px;">
										Licitación
									</button>
								@endif
								<button type="button" class="btn btn-default col-sm-12" id="btn_ind" style="margin-bottom: 3px;">
									Indicadores
								</button>
								@if($proyecto->tipo_proyecto==1)
								<button type="button" class="btn btn-default col-sm-12" id="btn_cot" style="margin-bottom: 3px;">
									Solicitudes
								</button>
								
								@endif
								<button type="button" class="btn btn-default col-sm-12" id="btn_contra" style="margin-bottom: 3px;">
										Contratos
								</button>
							</div>
					</div>
					<div class="panel panel-primary">
							<div class="panel-heading">Datos del Proyecto </div>
							<div class="panel-body" id="aqui_info">
								
							</div>
					</div>
				</div>
	</div>
	@if(isset($proyecto->presupuesto->presupuestodetalle))
	<div class="row" id="elformulario" style="display: none;">
            <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de solicitudes</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'SolicitudcotizacionController@store','class' => 'form-horizontal','id' => 'form_solicitudcotizacion']) }}
                    @include('solicitudcotizaciones.formulario')

                    <div class="form-group">
                        <center>
                            <button type="button" id="registrar_soli" class="btn btn-success">
                                Registrar
							</button>
							<button id="cancelar_soli" class="btn btn-primary">Cancelar</button>
                        </center>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
            </div>
		</div>
	@endif
</div>
<div id="modal_aqui"></div>
@include('proyectos.modales')
	@section('scripts')		
	<script>
		var elid='<?php echo $proyecto->id ?>';
		var eltipo='<?php echo $proyecto->tipo_proyecto ?>';
		$(document).ready(function (){
			informacion(elid);
			verificar_tipo(eltipo);
			$('#btn_pre').click(function (){
				$("#div_pre").show();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
		
				$("#btn_pre").removeClass('btn-default').addClass('btn-primary');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
			});
		
			$("#btn_ind").click(function (){
				$("#div_pre").hide();
				$("#div_ind").show();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").hide();
		
				$("#btn_ind").removeClass('btn-default').addClass('btn-primary');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				cargar_indicadores(elid);
			});
		
			$("#btn_cot").click(function (){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").show();
				$("#div_contra").hide();
				$("#div_lic").hide();
		
				$("#btn_cot").removeClass('btn-default').addClass('btn-primary');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				solicitudes(elid);
			});

			$("#btn_contra").click(function (){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").show();
				$("#div_lic").hide();
		
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-primary');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-default');
				contratos(elid);
			});

			$("#btn_lic").click(function (){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").show();
		
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-primary');
				//contratos(elid);
			});

		});
		function verificar_tipo(eltipito)
		{
			if(eltipito==2){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").hide();
				$("#div_contra").hide();
				$("#div_lic").show();
		
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_contra").removeClass('btn-primary').addClass('btn-default');
				$("#btn_lic").removeClass('btn-primary').addClass('btn-primary');
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