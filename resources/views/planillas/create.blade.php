@extends('layouts.app')

@section('migasdepan')
	@php
		$cuadro=[0=>'m',1=>'q'];
	@endphp
<h1>
	Planillas
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/planillas') }}"><i class="fa fa-dashboard"></i>Control de planillas</a></li>
	<li class="active">Planillas</li> </ol>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10" >
			<div class="box-header">
				<div class="btn-group pull-left">
					<a href="#" class="btn btn-primary active" id="bm" onclick="cambio('m');">Mensual</a>
					<a href="#" class="btn btn-primary" id="bq" onclick="cambio('q');">Quincenal</a>
				</div>
			</div>
			@for($i=0;$i<2;$i++)
				@if ($i==0)
					<div class="panel panel-primary" id='{{$cuadro[$i]}}' style="display:block;">
				@else
					<div class="panel panel-primary" id='{{$cuadro[$i]}}' style="display:none;">
				@endif
				<div class="panel-heading">Planilla de salarios</div>
				<div class="panel-body">
            {{ Form::open(['action'=> 'PlanillaController@store', 'class' => 'form-horizontal']) }}
            @include('planillas.planilla')
            <div class="form-group">
				<input type="hidden" name="tipo" value="{{$i+1}}">
  				<div class="col-md-6 col-md-offset-4">
					@if(App\Datoplanilla::comprobar($cuadro[$i]))
						<button type="submit" class="btn btn-success">
					@else
						<button type="submit" class="btn btn-success">
					@endif
  						<span class="glyphicon glyphicon-floppy-disk">Registrar</span>
					  </button>
  				</div>
			</div>
				{{ Form::close() }}
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
