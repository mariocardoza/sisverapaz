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
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Información</div>
                <div class="panel">
                    <table class="table">
                        <tr>
                            <td>Actividad</td>
                            <th></th>
                        </tr>
                        <tr>
                            <td>Responsable</td>
                            <th>{{$presupuesto->user->empleado->nombre}}</th>
                        </tr>
                        <tr>
                            <td>Nombre de la unidad</td>
                            <th>{{$presupuesto->unidad->nombre_unidad}}</th>
                        </tr>
                        <tr>
                            <td>Año</td>
                            <th>{{$presupuesto->anio}}</th>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <th>${{number_format(App\Presupuestounidad::total_presupuesto($presupuesto->id),2)}}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading">Presupuesto</div>
                <div class="panel">
                    <br>
                    <button class="btn btn-primary pull-right" type="button" id="add_material">Agregar</button>
                    <br><br>
                    <table class="table" id="example2">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Unidad de medida</th>
                                <th>Disponibles</th>
                                <th>Utilizados</th>
                                <th>Presupuestados</th>
                                <th>Precio</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presupuesto->presupuestodetalle as $key => $detalle)
                                <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$detalle->material->nombre}}</td>
                                <td>{{$detalle->material->unidadmedida->nombre_medida}}</td>
                                <td>{{$detalle->disponibles->count()}}</td>
                                <td>{{$detalle->utilizados->count()}}</td>
                                <td>{{$detalle->materialunidad->count()}}</td>
                                <td>${{number_format($detalle->precio,2)}}</td>
                                <td>
                                    <div class="btn-group">
                                    <a href="javascript:void(0)" id="eleditar" data-id="{{$detalle->id}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" id="eleliminar" data-id="{{$detalle->id}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></a>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
{!!Html::script('js/presupuestounidad.js?cod='.date('Yidisus'))!!}
@endsection