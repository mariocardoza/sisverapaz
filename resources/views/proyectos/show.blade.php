@extends('layouts.app')

@section('migasdepan')
<h1>Ver datos del proyecto:</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Ver proyecto</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-primary" id="div_pre">
                <div class="panel-heading">Datos del Presupuesto </div>
                <div class="panel-body">
					@if($proyecto->pre)
						@include('proyectos.show.presupuesto')
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
                <div class="panel-body" >
					@if($proyecto->indicadores->count() > 0)
					<ul class="todo-list" id="los_indicadores"></ul>
					<button type="button" id="add_indicador" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Agregar indicador</button>
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
                <div class="panel-heading">Datos de la cotización </div>
                <div class="panel-body">
					<center>
						<h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
						<span>Agregue una nueva contización para visualizar la información</span>
					</center>
                </div>
            </div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-primary">
							<div class="panel-heading">Opciones </div>
							<div class="panel-body">
								<button type="button" class="btn btn-primary col-sm-12" id="btn_pre" style="margin-bottom: 3px;">
									Presupuesto
								</button>
								<button type="button" class="btn btn-default col-sm-12" id="btn_ind" style="margin-bottom: 3px;">
									Indicadores
								</button>
								<button type="button" class="btn btn-default col-sm-12" id="btn_cot" style="margin-bottom: 3px;">
									Cotización
								</button>
							</div>
					</div>
					<div class="panel panel-primary">
							<div class="panel-heading">Datos del Proyecto </div>
							<div class="panel-body">
								@include('proyectos.show.informacion')
							</div>
					</div>
				</div>
    </div>
</div>
@include('proyectos.modales')
	@section('scripts')		
	<script>
		var elid='<?php echo $proyecto->id ?>';
		$(document).ready(function (){
			$('#btn_pre').click(function (){
				$("#div_pre").show();
				$("#div_ind").hide();
				$("#div_cot").hide();
		
				$("#btn_pre").removeClass('btn-default').addClass('btn-primary');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
			});
		
			$("#btn_ind").click(function (){
				$("#div_pre").hide();
				$("#div_ind").show();
				$("#div_cot").hide();
		
				$("#btn_ind").removeClass('btn-default').addClass('btn-primary');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
				$("#btn_cot").removeClass('btn-primary').addClass('btn-default');
				cargar_indicadores(elid);
			});
		
			$("#btn_cot").click(function (){
				$("#div_pre").hide();
				$("#div_ind").hide();
				$("#div_cot").show();
		
				$("#btn_cot").removeClass('btn-default').addClass('btn-primary');
				$("#btn_ind").removeClass('btn-primary').addClass('btn-default');
				$("#btn_pre").removeClass('btn-primary').addClass('btn-default');
			});

		});
		function cargar_indicadores(elid){
			porcentaje=0.0;
			var html="";
			$.ajax({
				url:'../indicadores/segunproyecto/'+elid,
				type:'GET',
				dataType:'json',
				data:{elid},
				success: function(json){
					if(json[0]==1){
						$(json[2]).each(function(index,value){
							var laclase="";
							if(value.estado==2){
								laclase='done';
							}
							porcentaje+=value.porcentaje;
							html+='<li class="'+laclase+'">'+
									'<span class="handle">'+
										'<i class="fa fa-ellipsis-v"></i>'+
									'</span>'+
								'<input type="checkbox" data-id="'+value.id+'" id="indicador_completado" value="">'+
								'<span class="text">'+value.nombre+'</span>'+
								'<small class="label label-danger"><i class="glyphicon glyphicon-ok"></i> '+value.porcentaje+' %</small>'+
								'<div class="tools">'+
									'<i data-id="'+value.id+'" id="editar_indicador" class="fa fa-edit"></i>'+
									'<i data-id="'+value.id+'" id="eliminar_indicador" class="fa fa-trash-o"></i>'+
								'</div>'+
								'</li>';
						});
						$("#los_indicadores").empty();
						$("#los_indicadores").append(html);
					}
				},error:function(error){
					console.log(error);
				}	
			});
		}
	</script>
	{!! Html::script('js/presupuestoR.js?cod='.date('yidisus')) !!}
	{!! Html::script('js/indicadores.js?cod='.date('yidisus')) !!}
	
	@endsection
@endsection