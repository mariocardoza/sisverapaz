@extends('layouts.app')

@section('migasdepan')
<h1>
	Materiales o Bienes
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
	<li class="active">Listado de materiales o bienes</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box">
		<div class="box-header">
			<h3 class="box-tittle"></h3>
			<div class="btn-group pull-right">
				<a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
				<a href="{{ url('/materiales?estado=1') }}" class="btn btn-primary">Activos</a>
				<a href="{{ url('/materiales?estado=2') }}" class="btn btn-primary">Papelera</a>
			</div>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example2">
				<thead>
					<th>N°</th>
					<th>Nombre de catálogo</th>
					<th>Precio estimado</th>
					<th>Unidad de medida</th>
					<th>Categoría</th>
					<th>Tipo</th>
					<th>Acción</th>
					<?php $contador = 0 ?>
				</thead>
			<tbody>
				@foreach($materiales as $key => $material)
				<tr>
					<td>{{ $key+1 }}</td>
					<td>{{ $material->nombre }}</td>
					<td>{{ $material->precio_estimado }}</td>
					<td>{{ $material->unidadmedida->nombre_medida }}</td>
					<td>{{ $material->categoria->nombre_categoria }}</td>
					<td>
						@if($material->servicio==0)
						No es servicio
						@else
						Es servicio
						@endif
					</td>
					<td>
						@if($material->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
					<a href="javascript:(0)" id="edit" data-id="{{$material->id}}" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></a>
						<button class="btn btn-danger btn-sm" type="button" onclick={{ "baja(".$material->id.",'materiales')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success btn-sm" type="button" onclick={{ "alta(".$material->id.",'material')" }}><span class="fa fa-refresh btn-sm"></span></button>
						{{ Form::close()}}
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
			</table>
			<div class="pull-right">
				
			</div>
		</div>
	</div>
	</div>
	<!--@include('materiales.modales')
	<div id="aqui_modal"></div>-->
</div>


@include("materiales.modales")
@endsection

@section("scripts")
<script>
	$(document).ready(function(e){
		$(document).on("click","#btnmodalagregar", function(e){
			$("#modal_registrar").modal("show");
		});

		$(document).on("click","#btnguardar", function(e){
			e.preventDefault();
			var datos = $("#form_material").serialize();
			modal_cargando();
			$.ajax({
				url:"materiales",
				type:"post",
				data:datos,
				success: function(retorno){
					if(retorno[0] == 1){
						toastr.success("Registrado con éxito");
						$("#modal_registrar").modal("hide");
						window.location.reload();
					}
					else{
						toastr.error("Falló");
						swal.closeModal();
					}
				},

				error: function(error){
					console.log();
					$(error.responseJSON.errors).each(
						function(index,valor){
							toastr.error(valor.nombre);
						});
					swal.closeModal();
				}
			});
		});

		$(document).on("click", "#edit", function(){
			var id = $(this).attr("data-id");
			$.ajax({
				url:"materiales/"+id+"/edit",
				type:"get",
				data:{},
				success: function(retorno){
					if(retorno[0] == 1){
						$("#modal_editar").modal("show");
						$("#e_nombre").val(retorno[2].nombre);
						$("#elid").val(retorno[2].id);
					}
					else{
						toastr.error("error");
					}
				}
			});
		});//modal editar

		$(document).on("click", "#btneditar", function(e){
			var id = $("#elid").val();
			var nombre = $("#e_nombre").val();
			modal_cargando();
			$.ajax({
				url:"materiales/"+id,
				type:"put",
				data:{nombre},
				success: function(retorno){
					if(retorno[0] == 1){
						toastr.success("Exitoso");
						$("#modal_editar").modal("hide");
						window.location.reload();
					}
					else{
						toastr.error("error");
						swal.closeModal();
					}
				},
				error: function(error){
					console.log();
					$(error.responseJSON.errors).each(function(index,valor){
						toastr.error(valor.nombre);
					});
					swal.closeModal();
				}
			});
		});
		$(document).on()
	});
</script>
@endsection