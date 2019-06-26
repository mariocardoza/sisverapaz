@extends('layouts.app')
@section('migasdepan')
  <h1><small>Ver negocio <b>{{ $negocio->nombre }}</b></small></h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/negocios') }}"><i class="fa fa-dashboard"></i> Negocio</a></li>
    <li class="active">Ver</li>
  </ol>
@endsection

@section('content')
<div class="col-xs-12" ng-init='position={lat:{{ $negocio->lat }}, lng: {{ $negocio->lng }}, id: {{ $negocio->id }}}' 
  ng-controller='ApplicationControllers'>
  <div map-lazy-load="https://maps.google.com/maps/api/js" 
    map-lazy-load-params="[[googleMapsUrl]]" class="container-maps">
    <ng-map center='13.6443693,-88.8701964' class="center-maps" style='height: 500px;' zoom="17" on-click="addMarker()">
      <marker ng-repeat="position in positions" position="[[position.lat]], [[position.lng]]" animation="Animation.BOUNCE"></marker>
    </ng-map>
  </div>
</div>
{!! Html::script('js/app-map.js') !!}
@endsection