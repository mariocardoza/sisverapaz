@extends('layouts.app')

@section('migasdepan')
<h1>
	Cargos
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i>Inicio</a></li>
	<li class="active">Listado de cargos</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box">
		<div class="box-header">
			<h3 class="box-tittle"></h3>
			<div class="btn-group pull-right">
				<a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
				<a href="{{ url('/cargos?estado=1') }}" class="btn btn-primary">Activos</a>
				<a href="{{ url('cargos?estado=0') }}" class="btn btn-primary">Papelera</a>
			</div>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example2">
				<thead>
					<th>Id</th>
					<th>Cargos</th>
					<th>Categoría</th>
					<th>Acciones</th>
				</thead>
			<tbody>
				@foreach($cargos as $key => $cargo)
				<tr>
					<td>{{ $key+1}}</td>
					<td>{{ $cargo->cargo }}</td>
					<td>{{$cargo->catcargo->nombre}}</td>
					<td>
						@if($cargo->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
						<a href="javascript:(0)" id="edit" data-id="{{$cargo->id}}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span></a>
						<button class="btn btn-danger" type="button" onclick={{ "baja($cargo->id,'cargos')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success" type="button" onclick={{ "alta($cargo->id,'cargos')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
			</table>
		</div>
	</div>
	</div>
</div>

@include("cargos.modales")
@endsection

@section("scripts")
<script>
	$(document).ready(function(e){
		$(document).on("click", "#btnmodalagregar", function(e){
			$("#modal_registrar").modal("show");
		});

		$(document).on("click", "#btnguardar", function(e){
			e.preventDefault();
			var datos= $("#form_cargo").serialize();
			$.ajax({
				url:"cargos",
				type:"post",
				data:datos,
				success:function(retorno){
					if(retorno[0] == 1){
						toastr.success("Registrado con éxito");
						$("#modal_registrar").modal("hide");
						window.location.reload();
					}
					else{
						toastr.error("Falló");
					}
				},
				error:function(error){
					console.log();
					$.each(error.responseJSON.errors, function(key, value){
						toastr.error(value);
					});
					swal.closeModal();
				}
			});
		});
		$(document).on("click", "#edit", function(){
			var id = $(this).attr("data-id");
			$.ajax({
				url:"cargos/"+id+"/edit",
				type:"get",
				data:{},
				success:function(retorno){
					if(retorno[0] == 1){
						$("#modal_editar").modal("show");
						$("#e_cargo").val(retorno[2].cargo);
						$("#elid").val(retorno[2].id);
						$('#catcargo_edit').val(retorno[2].catcargo_id).attr('selected','selected');
						$("#catcargo_edit").trigger("chosen:updated");
					}
					else{
						toastr.error("error");
					}
				}
			});
		});  //Fin modal de editar

		$(document).on("click", "#btneditar", function(e){
			var id = $("#elid").val();
			var cargo = $("#e_cargo").val();
			var catcargo_id=$("#catcargo_edit").val();
			$.ajax({
				url:"cargos/"+id,
				type: "put",
				data: {cargo,catcargo_id},
				success:function(retorno){
					if(retorno[0] == 1){
						toastr.success("Exitoso");
						$("#modal_editar").modal("hide");
						window.location.reload();
					}
					else{
						toastr.error("error");
					}
				}
			});
		});  //Fin btneditar

		$(document).on();
	});
</script>
@endsection