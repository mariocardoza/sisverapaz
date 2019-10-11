@extends('layouts.app')

@section('migasdepan')
<h1>
        Pagina principal
        <small>Control panel UACI</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Pagina principal</li>
      </ol>

@endsection
@section('content')
@php
   $proveedores= App\Proveedor::mas_utilizados();
   
@endphp
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{\App\Requisicione::where('user_id',Auth()->user()->id)->where('created_at','<=',date('Y'.'-12-31'))->count()}}</h3>

        <p>Mis requisiciones en el año {{date('Y')}}</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="{{url('requisiciones/porusuario')}}" class="small-box-footer">Ver todas <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{cantprov()}}</h3>

              <p>Proveedores Registrados</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('/proveedores') }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
</div>
<!-- /.row -->
<div class="row">
  <div class="col-lg-6">
      <div id="container"></div>
      <table id="datatable" class="hide">
          <thead>
              <tr>
                  <th>Proveedor</th>
                  <th>Veces</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($proveedores as $p)
                <tr>
                <td>{{$p->nombre}}</td>
                <td>{{$p->total}}</td>
                </tr>
            @endforeach
          </tbody>
      </table>
  </div>
  <div class="col-lg-6"></div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function(e){
  Highcharts.chart('container', {
    data: {
        table: 'datatable'
    },
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Proveedores más utilizados'
    },
   
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Units'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        }
    }
});
});
</script>
@endsection
