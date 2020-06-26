@extends('layouts.app')

@section('migasdepan')
<h1>
        Presupuestos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        @if(Auth()->user()->hasRole('uaci'))
        <li><a href="{{ url('/presupuestounidades') }}"><i class="glyphicon glyphicon-home"></i> Presupuestos</a></li>
        @else 
        <li><a href="{{ url('/presupuestounidades/porunidad') }}"><i class="glyphicon glyphicon-home"></i> Mis presupuestos</a></li>
        @endif
        <li class="active">Detalle</li>
      </ol>
@endsection

@section('content')
    <div class="row">
      @if(Auth()->user()->hasRole('uaci') && $presupuesto->estado == 1)
      <center>
          <button type="button" class="btn btn-primary estado" data-estado="3" data-id="{{$presupuesto->id}}">Aprobar</button>
          <button class="btn btn-danger estado" type="button" data-estado="2" data-id="{{$presupuesto->id}}">Rechazar</button>
          <a href="{{ url('reportesuaci/presupuestounidad/'.$presupuesto->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a>
      </center>
      @endif
      <br>
        <div class="col-xs-12" id="elpresupuesto" style="display: block;">Presupuesto</div>
        <div class="col-xs-12" id="panel_registrar" style="display: none;">
            <div class="panel panel-primary">
              <div class="panel-heading">Registrar</div>
              <div class="panel">
                <form id="form_presupuesto" class="">
                  <br />
                    <input type="hidden" value="{{$presupuesto->id}}" name="presupuestounidad_id">
                  @include('unidades.presupuestos.nuevo')
                  <br>
                  <div class="form-group">
                    <center>
                      <button type="button" id="guardar" class="btn btn-success">
                        Agregar
                      </button>
                      <button class="btn btn-info" id="cancelar_guardar" type="button">
                        Cancelar
                      </button>
                    </center>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xs-12" id="panel_editar" style="display: none;">
            <div class="panel panel-primary">
              <div class="panel-heading">Editar</div>
              <div class="panel-body" id="form_aqui"></div>
            </div>

          </div>

        
    </div>
    <div id="modal_aqui"></div>
    @include('unidades.presupuestos.modales')
@endsection
@section('scripts')
<script>
    var id_presupuesto='<?php echo $presupuesto->id; ?>';
</script>
{!!Html::script('js/presus.js?cod='.date('Yidisus'))!!}
@endsection