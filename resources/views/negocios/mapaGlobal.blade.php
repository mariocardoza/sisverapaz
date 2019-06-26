@extends('layouts.app')

@section('content')
<div class="col-xs-12" ng-controller='MapaControllers'>
  <div map-lazy-load="https://maps.google.com/maps/api/js" 
    map-lazy-load-params="[[googleMapsUrl]]" class="container-maps">
    <ng-map center='13.6443693,-88.8701964' class="center-maps" style='height: 700px;' zoom="17" >
      <marker ng-repeat="position in positions" on-click='showInform(position)'
        position="[[position.lat]], [[position.lng]]"></marker>
      <info-window id="foo-iw">
        <div ng-non-bindable="">
          Id: [[ vm.item.data.id ]]
        </div>
      </info-window>
    </ng-map>
  </div>
</div>
{!! Html::script('js/app-map.js') !!}
@endsection