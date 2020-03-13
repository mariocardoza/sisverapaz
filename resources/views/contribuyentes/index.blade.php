@extends('layouts.angular')

@section('migasdepan')
  <h1>
    Contribuyentes
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">Listado de contribuyentes</li>
  </ol>
@endsection

@section('content')
 <div ui-view></div>
@endsection