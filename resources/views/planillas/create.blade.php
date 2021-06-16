@extends('layouts.app')

@section('migasdepan')
	@php
		$cuadro=[0=>'m',1=>'q'];
	@endphp
<h1>
	Planillas
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
	<li><a href="{{ url('/planillas') }}"><i class="fa fa-dashboard"></i>Planillas</a></li>
	<li class="active">Registro</li> </ol>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12" >
		<div class="box-header">
			<p></p>
			<div class="btn-group pull-left">
				<a href="#" class="btn btn-primary active" id="bm" onclick="cambio('m');">Mensual</a>
				<p></p>
				<!--a href="#" class="btn btn-primary" id="bq" onclick="cambio('q');">Quincenal</a-->
			</div>
		</div>
		<p></p>
		@for($i=0;$i<2;$i++)
			@if ($i==0)
				<div class="panel panel-primary" id='{{$cuadro[$i]}}' style="display:block;">
			@else
				<div class="panel panel-primary" id='{{$cuadro[$i]}}' style="display:none;">
			@endif
			<div class="panel-heading">Planilla de salarios</div>
			<div class="panel-body">
		{{ Form::open(['action'=> 'PlanillaController@store', 'class' => 'form-horizontal']) }}
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="col-md-2 control-label">Mes: </label>
					<div class="col-md-4">
						<select name="mes" id="" class="chosen-select-width">
							<option {{ (date('m')== 1 ? 'selected' : '') }} value="1">Enero</option>
							<option {{ (date('m')== 2 ? 'selected' : '') }} value="2">Febrero</option>
							<option {{ (date('m')== 3 ? 'selected' : '') }} value="3">Marzo</option>
							<option {{ (date('m')== 4 ? 'selected' : '') }} value="4">Abril</option>
							<option {{ (date('m')== 5 ? 'selected' : '') }} value="5">Mayo</option>
							<option {{ (date('m')== 6 ? 'selected' : '') }} value="6">Junio</option>
							<option {{ (date('m')== 7 ? 'selected' : '') }} value="7">Julio</option>
							<option {{ (date('m')== 8 ? 'selected' : '') }} value="8">Agosto</option>
							<option {{ (date('m')== 9 ? 'selected' : '') }} value="9">Septiembre</option>
							<option {{ (date('m')== 10 ? 'selected' : '') }} value="10">Octubre</option>
							<option {{ (date('m')== 11 ? 'selected' : '') }} value="11">Noviembre</option>
							<option {{ (date('m')== 12 ? 'selected' : '') }} value="12">Diciembre</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label col-md-2">Año:</label>
					<div class="col-md-4">
						<input type="number" name="anio" class="form-control" value="{{date("Y")}}">
					</div>
				</div>
			</div>
		</div>
		@include('planillas.planilla')
		<div class="form-group">
			<input type="hidden" name="tipo" value="{{$i+1}}">
			<p></p>
			<div class="col-md-6 col-md-offset-5">
				
				@if(App\Datoplanilla::comprobar($cuadro[$i]))
					<button type="submit" class="btn btn-success">
				@else
					<button type="submit" class="btn btn-success">
				@endif
					<span class=""> Agregar</span>
					</button>
			</div>
		</div>
			{{ Form::close() }}
			</div>
		</div>
	@endfor
	</div>
</div>
<script type="text/javascript">
	function cambio(letra){
		var cuadro= ['m','q','s'];
		for(i=0;i<3;i++){
			if(cuadro[i]==letra){
				$("#"+cuadro[i]).css('display', 'block');
			}else{
				$("#b"+cuadro[i]).removeClass('active');
				$("#"+cuadro[i]).css('display', 'none');
			}
		}
	}
</script>
@endsection
