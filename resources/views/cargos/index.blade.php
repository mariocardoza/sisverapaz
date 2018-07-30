@extends('layouts.app')

@section('migasdepan')
<h1>
        Cargos
        <small>Control de cargos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/cargos') }}"><i class="fa fa-dashboard"></i> Cargos</a></li>
        <li class="active">Listado de cargos</li>
      </ol>
@endsection

@section('content')
<div id="app">
  <cargos></cargos>
</div>
@endsection
@section('scripts')
{{Html::script('js/vue.js')}}
@endsection
