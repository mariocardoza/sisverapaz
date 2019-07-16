@extends('layouts.app')

@section('migasdepan')
<h1>
Ver detalle del plan anual
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/paacs') }}"><i class="fa fa-dashboard"></i> Plan anual</a></li>
        <li class="active">Detalle del presupuesto</li>
      </ol>
@endsection

@section('content')
<div class="row">
        <div class="col-xs-12" id="elplan" style="display: block;">
            
        </div>
        <div class="col-xs-12" id="panel_registrar" style="display: none;">
          <div class="panel panel-primary">
            <div class="panel-heading">Registrar </div>
            <div class="panel">
              <form id="form_paac" class="form-horizontal">
                <br>
                
              <input type="hidden" name="paac_id" value="{{$paac->id}}">
                @include('paacs.formulario')
                <div class="form-group">
                  <center>
                      <button type="button" id="guardar" class="btn btn-success">Agregar</button>
                      <button class="btn btn-info" id="cancelar_guardar" type="button">Cancelar</button>
                  </center>

              </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-xs-12" id="panel_editar" style="display: none;">
          <div class="panel panel-primary">
            <div class="panel-heading">Editar </div>
            <div class="panel" id="form_aqui">
          
            </div>
          </div>
        </div>
  </div>

@endsection
@section('scripts')
<script>
var idpaac='<?php echo $paac->id ?>';
</script>
{!! Html::script('js/paac.js?cod='.date('Yidisus')) !!}
@endsection