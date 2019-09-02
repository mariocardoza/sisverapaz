@extends('layouts.app')

@section('migasdepan')
<h1>
  Panel de inicio
  <small>Administrador</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
  <li class="active">Panel de inicio</li>
</ol>
@endsection
@section('content')
<div class="row">
  @if(Auth()->user()->hasRole('admin'))
      @include('partials.homeadmin')
  @elseif(Auth::user()->hasRole('uaci'))
      @include('partials.homeuaci')
  @elseif (Auth::user()->hasRole('catastro'))
    @include('partials.homeryct')
  @elseif (Auth::user()->hasRole('tesoreria'))
    @include('partials.homete')
  @elseif (Auth::user()->hasRole('colector'))
    @include('partials.homecolec')
  @elseif (Auth::user()->hasRole('usuario'))
    @include('partials.homeusuario')
  @endif
</div>
@endsection
