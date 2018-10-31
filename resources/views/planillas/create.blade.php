@extends('layouts.app')

@section('migasdepan')
	@php
		$cuadro=[0=>'m',1=>'q',2=>'s'];
	@endphp
<h1>
	Planillas
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/detalleplanillas') }}"><i class="fa fa-dashboard"></i>Detalles de planilla</a></li>
	<li class="active">Planillas</li> </ol>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10" >
			<div class="box-header">
				<div class="btn-group pull-left">
					<a href="#" class="btn btn-primary active" onclick="cambio('m');">Mensual</a>
					<a href="#" class="btn btn-primary" onclick="cambio('q');">Quincenal</a>
					<a href="#" class="btn btn-primary" onclick="cambio('s');">Semanal</a>
				</div>
			</div>
			@for($i=0;$i<3;$i++)
				@if ($i==0)
					<div class="panel panel-primary" id='{{$cuadro[$i]}}' style="display:block;">
				@else
					<div class="panel panel-primary" id='{{$cuadro[$i]}}' style="display:none;">
				@endif
				<div class="panel-heading">{{$cuadro[$i]}}Planilla de salarios</div>
				<div class="panel-body">
            {{ Form::open(['action'=> 'PlanillaController@store', 'class' => 'form-horizontal']) }}
            @include('errors.validacion')
            @include('planillas.planilla')
            <div class="form-group">
							<input type="hidden" name="tipo" value="{{$i+1}}">
  						<div class="col-md-6 col-md-offset-4">
  							<button type="submit" class="btn btn-success">
  								<span class="glyphicon glyphicon-floppy-disk">Registrar</span>
  							</button>
  						</div>
  						{{ Form::close() }}
  					</div>
				</div>
			</div>
		@endfor
		</div>
	</div>
</div>
<script type="text/javascript">
	function cambio(letra){
		var cuadro= ['m','q','s'];
		for(i=0;i<3;i++){
			alert();
			if(cuadro[i]==letra){
				$("#"+letra).css('display', 'block');
			}else{
				$("#"+letra).css('display', 'none');
			}
		}
	}
</script>
@endsection
