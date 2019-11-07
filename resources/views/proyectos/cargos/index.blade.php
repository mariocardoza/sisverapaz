@extends('layouts.app')

@section('migasdepan')
<h1>
	Cargos para proyectos
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i>Inicio</a></li>
	<li class="active">Listado de cargos para proyectos</li>
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
					<tr>
                        <th>N°</th>
                        <th>Cargos</th>
                        <th class="text-right">Salario por día</th>
                        <th>Acción</th>
                    </tr>
				</thead>
			<tbody>
				@foreach($cargos as $key => $cargo)
				<tr>
					<td>{{ $key+1}}</td>
					<td>{{ $cargo->nombre }}</td>
					<td class="text-right">${{number_format($cargo->salario_dia,2)}}</td>
					<td>
						@if($cargo->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
						<a href="javascript:(0)" id="edit" data-id="{{$cargo->id}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
						<button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$cargo->id.",'cargos')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$cargo->id.",'cargos')" }}><span class="glyphicon glyphicon-trash"></span></button>
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

@include("proyectos.cargos.modal")
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
            modal_cargando();
			$.ajax({
				url:"cargoproyectos",
				type:"post",
				data:datos,
				success:function(retorno){
					if(retorno[0] == 1){
						toastr.success("Registrado con éxito");
                        $("#modal_registrar").modal("hide");
                        $("#form_cargo").trigger("reset");
                        window.location.reload();
                        swal.closeModal();
					}
					else{
                        toastr.error("Falló");
                        swal.closeModal();
					}
				},
				error:function(error){
					console.log();
					$.each(error.responseJSON.errors, function( key, value ) {
					    toastr.error(value);
                    });
                    swal.closeModal();
				}
			});
		});
		$(document).on("click", "#edit", function(){
			var id = $(this).attr("data-id");
			$.ajax({
				url:"cargoproyectos/"+id+"/edit",
				type:"get",
				data:{},
				success:function(retorno){
					if(retorno[0] == 1){
						$("#modal_editar").modal("show");
						$("#e_nombre").val(retorno[2].nombre);
						$("#e_salario").val(retorno[2].salario_dia);
						$("#elid").val(retorno[2].id);
						
					}
					else{
						toastr.error("error");
					}
				}
			});
		});  //Fin modal de editar

		$(document).on("click", "#btneditar", function(e){
			var id = $("#elid").val();
			var nombre = $("#e_nombre").val();
            var salario_dia=$("#e_salario").val();
            modal_cargando();
			$.ajax({
				url:"cargoproyectos/"+id,
				type: "put",
				data: {nombre,salario_dia},
				success:function(retorno){
					if(retorno[0] == 1){
						toastr.success("Exitoso");
                        $("#modal_editar").modal("hide");
                        $("#form_edit").trigger("reset");
                        window.location.reload();
                        swal.closeModal();
					}
					else{
                        toastr.error("error");
                        swal.closeModal();
					}
				},error: function(){
                    swal.closeModal();
                }
			});
		});  //Fin btneditar

		$(document).on();
	});
</script>
@endsection