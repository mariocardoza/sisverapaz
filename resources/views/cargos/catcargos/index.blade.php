@extends('layouts.app')

@section('migasdepan')
<h1>
	Categorías
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i>Inicio</a></li>
	<li class="active">Listado de categorías</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box">
		<div class="box-header">
			<h3 class="box-tittle">Listado</h3>
			<div class="btn-group pull-right">
				<a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
				<a href="{{ url('/catcargos?estado=1') }}" class="btn btn-primary">Activos</a>
				<a href="{{ url('/catcargos?estado=0') }}" class="btn btn-primary">Papelera</a>
			</div>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example2">
				<thead>
					<th>N°</th>
					<th>Nombre</th>
					<th>Acciones</th>
				</thead>
			<tbody>
				@foreach($catcargos as $key => $catcargo)
				<tr>
					<td>{{ $key+1}}</td>
					<td>{{ $catcargo->nombre }}</td>
					<td>
						@if($catcargo->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
						<a href="javascript:(0)" id="edit" data-id="{{$catcargo->id}}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span></a>
						<button class="btn btn-danger" type="button" onclick={{ "baja('$catcargo->id','catcargos')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success" type="button" onclick={{ "alta(".$catcargo->id.",'catcargos')" }}><span class="glyphicon glyphicon-trash"></span></button>
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

@include("cargos.catcargos.modales")
@endsection

@section('scripts')
<script>
	$(document).ready(function(e){
		$(document).on('click','#btnmodalagregar',function(e){
			e.preventDefault();////// Para quitar la funci[on de un boton
			$('#modal_registrar').modal('show');
		});

		$(document).on('click','#btnguardar',function(e){
			e.preventDefault();
			var cargo= $('#form_catcargo').serialize();

			console.log(cargo);

			modal_cargando();
			$.ajax({
				url: "catcargos",
				type: "post",
				data: cargo,
				success:function(json){
					if(json[0]==1)
					{
						toastr.success('Categoría guardada con éxito');
						location.reload();
					}
					else{
						toastr.error('Ocurrió un error');
						swal.closeModal();
					}
				},
				error:function(error){
					$.each(error.responseJSON.errors,function(i,v){
						toastr.error(v);
					});
					swal.closeModal();
				}
			});
		});

		$(document).on('click','#edit',function(e){
			e.preventDefault();
			var id = $(this).attr("data-id");
			$.ajax({
				url:"catcargos/"+id+"/edit",
				type:"get",
				data:{},
				success:function(retorno){
					if(retorno[0] == 1){
						$("#modal_editar").modal("show");
						$("#e_catcargo").val(retorno[2].nombre);
						$("#elid").val(retorno[2].id);
					}
					else{
						toastr.error("error");
					}
				}
			});
		});////Modal editar

		$(document).on("click", "#btneditar", function(e){
			var id = $("#elid").val();
			var nombre = $("#e_catcargo").val();

			modal_cargando();
			$.ajax({
				url:"catcargos/"+id,
				type:"put",
				data:{nombre},
				success:function(retorno){
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
				error:function(){
					swal.closeModal();
				}
			});
		});///btn editar

		$(document).on();
	});
</script>
@endsection