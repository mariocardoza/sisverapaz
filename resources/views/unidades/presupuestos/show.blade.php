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
            <div class="col-md-9">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Presupuesto</div>
                        <div class="panel">
                            <br>
                            @if($presupuesto->estado==1)
                            <button class="btn btn-primary pull-right" type="button" id="add_material">Agregar</button>
                            <br><br>
                            @endif
                            <table class="table" id="">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre</th>
                                        <th>Unidad de medida</th>
                                        <th>Disponibles</th>
                                        @if($presupuesto->estado==3)
                                        <th>Utilizados</th>
                                        <th>Presupuestados</th>
                                        @endif
                                        <th>Precio</th>
                                        @if($presupuesto->estado==1)
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $categ=array();
                                        if(isset($presupuesto->presupuestodetalle)):
                                            foreach($presupuesto->presupuestodetalle as $detalle):
                                                if(!in_array($detalle->material->categoria->nombre_categoria,$categ)){
                                                    $categ[]=$detalle->material->categoria->nombre_categoria;
                                                }
                                            endforeach;
                                        endif;
                                    @endphp 
                                    @foreach($categ as $c)
                                        @if($presupuesto->estado==3)
                                            <tr><th colspan="7" class="text-center">{{$c}}</th></tr>
                                        @else
                                            <tr><th colspan="6" class="text-center">{{$c}}</th></tr>
                                        @endif
                                    
                                        @foreach ($presupuesto->presupuestodetalle as $key => $detalle)
                                            @if(($c==$detalle->material->categoria->nombre_categoria))
                                                <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$detalle->material->nombre}}</td>
                                                <td>{{$detalle->material->unidadmedida->nombre_medida}}</td>
                                                <td>{{$detalle->disponibles->count()}}</td>
                                                @if($presupuesto->estado==3)
                                                <td>{{$detalle->utilizados->count()}}</td>
                                                <td>{{$detalle->materialunidad->count()}}</td>
                                                @endif
                                                <td>${{number_format($detalle->precio,2)}}</td>
                                                @if($presupuesto->estado==1)
                                                <td>
                                                    <div class="btn-group">
                                                    <a href="javascript:void(0)" id="eleditar" data-id="{{$detalle->id}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                        <a href="javascript:void(0)" id="eleliminar" data-id="{{$detalle->id}}" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></a>
                                                    </div>
                                                </td>
                                                @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Información</div>
                <div class="panel">
                    <br>
                        @if(Auth()->user()->hasRole('uaci') && $presupuesto->estado == 1)
                        <center>
                            <button type="button" class="btn btn-primary estado" data-estado="3" data-id="{{$presupuesto->id}}">Aprobar</button>
                            <button class="btn btn-danger estado" type="button" data-estado="2" data-id="{{$presupuesto->id}}">Rechazar</button>
                            <a href="{{ url('../reportesuaci/presupuestounidad/'.$presupuesto->id)}}" class="btn btn-primary"><i class="fa fa-print"></i></a>
                        </center>
                        @endif
                        <center>
                            <a href="{{ url('reportesuaci/presupuestounidad/'.$presupuesto->id)}}" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i></a>
                        </center>
                    <table class="table">
                        <tr>
                            <td colspan="2">
                                {!! App\Presupuestounidad::estado_ver($presupuesto->id) !!}
                            </td>
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