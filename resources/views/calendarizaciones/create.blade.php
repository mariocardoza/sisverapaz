@extends('layouts.app')

@section('migasdepan')
<h1>
	Calendarización
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/calendarizaciones') }}"><i class="fa fa-dashboard"></i>Calendarización</a></li>
	<li class="active">Registro</li> </ol>
	
@endsection

@section('content')
	@include('calendarizaciones.modal')
	<div class="row">
		<div class="col-md-12">
		  <div class="panel panel-primary">
			<div class="panel-heading">Calendario</div>
			<div class="panel">
			  <div id="calendario"></div>
			</div>
		  </div>
		</div>
	  </div>
@endsection
@section('scripts')
{{Html::script('js/calendarizacion.js?cod='.date("Yidisus"))}}
@endsection