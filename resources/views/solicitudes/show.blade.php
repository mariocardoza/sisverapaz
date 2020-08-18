@extends('layouts.app')

@section('migasdepan')
<h1>
        &nbsp;
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        @if(Auth()->user()->hasRole('uaci'))
        <li><a href="{{ url('/requisiciones') }}"><i class="fa fa-balance-scale"></i> Requisiciones</a></li>
        @else
        <li><a href="{{ url('/requisiciones/porusuario') }}"><i class="fa fa-balance-scale"></i> Mis requisiciones</a></li>
        @endif
        <li class="active">Ver</li>
      </ol>
@endsection

@section('content')
<style>
.subir{
    padding: 5px 10px;
    background: #f55d3e;
    color:#fff;
    border:0px solid #fff;
}

.skin-blue{
  padding-right: 0px !important;
}
 
.subir:hover{
    color:#fff;
    background: #f7cb15;
}
</style>
<div class="">
    <div class="row">
        <div class="col-md-9">
          <div id="elshow">
            <div class="btn-group">
              <button class="btn btn-primary que_ver" data-tipo="1" >Consolidado</button>
              @if(Auth()->user()->hasRole('uaci'))
              <button class="btn btn-primary que_ver" data-tipo="2">Solicitudes</button>
              <button class="btn btn-primary que_ver" data-tipo="3">Contratos</button>
              @endif
            </div><br><br>
            <div class="panel panel-primary" id="requi" style="display: block;">
              <div class="panel-heading">Detalle</div>
              <div class="panel-body" id="body_requi">
                <table class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>U/M</th>
                            <th>Categoría</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($combinadas as $i=>$c)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$c->codigo}}</td>
                                <td>{{$c->nombre}}</td>
                                <td>{{$c->suma}}</td>
                                <td>{{$c->nombre_medida}}</td>
                                <td>{{$c->cnombre}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
            <div class="panel panel-primary" id="soli" style="display: none;">
              <div class="panel-heading">Solicitud de cotización</div>
              <div class="panel" id="aquiponer_soli">
                
                
                
              </div>
            </div>
            <div class="panel panel-primary" id="coti" style="display: none;">
              <div class="panel-heading">Contratos</div>
              <div class="panel" id="aqui_contra">    
                
              </div>
            </div>
          </div>
          
          <div id="elformulario" style="display: none;"></div>
        </div>
        <div class="col-md-3">
          <div class="panel panel-primary">
              <div class="panel-heading">Información sobre las requisiciones </div>
              <div class="panel-body" id="info_aquii"> 
                <br>     
                <span>Este es un consolidado de las siguientes requisiciones:</span>  
                <ul>
                    @foreach ($solicitud->requisiciones as $r)
                        <li><a href="{{url('reportesuaci/requisicionobra/'.$r->id)}}" target="_blank">{{$r->codigo_requisicion}}</a></li> 
                    @endforeach
                    
                </ul>
              </div>
          </div>
      </div>
    </div>
    <div id="modal_aqui"></div>
</div>
@include("solicitudes.modales")
@endsection
@section('scripts')
<script>
  var elid='<?php echo $solicitud->id ?>';
</script>
{!! Html::script('js/solicitudrequisicion_show.js?cod='.date('Yidisus')) !!}
@endsection
