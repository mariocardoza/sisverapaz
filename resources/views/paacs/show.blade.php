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
        <div class="col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Presupuesto </div>
                <div class="panel-body">
                  <a href="{{ url('/paacs/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar elementos</a>
                <br>
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Año de ejecución: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$paac->anio}}</label><br>
                        </div>

                         <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
                            <label for="monto" class="col-md-4 control-label">Descripción del plan anual: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$paac->descripcion}}</label><br>
                        </div>

                        <div class="form-group{{ $errors->has('fuente_financiamiento') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Monto total: </label>
                            <label for="nombre" class="col-md-4 control-label">${{number_format($paac->total,2)}}</label><br>
                        </div>



                        <div style="overflow-x:auto;">
                          <table class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                              <?php
                              $enero=0.0;
                              $febrero=0.0;
                              $marzo=0.0;
                              $abril=0.0;
                              $mayo=0.0;
                              $junio=0.0;
                              $julio=0.0;
                              $agosto=0.0;
                              $septiembre=0.0;
                              $octubre=0.0;
                              $noviembre=0.0;
                              $diciembre=0.0;
                              $total=0.0;
                              ?>
                              <tr>
                                <th>Obra, bien o servicio</th>
                                <th>Enero</th>
                                <th>Febrero</th>
                                <th>Marzo</th>
                                <th>Abril</th>
                                <th>Mayo</th>
                                <th>Junio</th>
                                <th>Julio</th>
                                <th>Agosto</th>
                                <th>Septiembre</th>
                                <th>Octubre</th>
                                <th>Noviembre</th>
                                <th>Diciembre</th>
                                <th>Total</th>
                                <th>Acción</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($detalles as $detalle)
                                <?php
                                $enero=$enero+$detalle->enero;
                                $febrero=$febrero+$detalle->febrero;
                                $marzo=$marzo+$detalle->marzo;
                                $abril=$abril+$detalle->abril;
                                $mayo=$mayo+$detalle->mayo;
                                $junio=$junio+$detalle->junio;
                                $julio=$julio+$detalle->julio;
                                $agosto=$agosto+$detalle->agosto;
                                $septiembre=$septiembre+$detalle->septiembre;
                                $octubre=$octubre+$detalle->octubre;
                                $noviembre=$noviembre+$detalle->noviembre;
                                $diciembre=$diciembre+$detalle->diciembre;
                                $total=$total+$detalle->subtotal;
                                ?>
                              <tr>
                                <td>{{$detalle->obra}}</td>
                                <td>${{number_format($detalle->enero,2)}}</td>
                                <td>${{number_format($detalle->febrero,2)}}</td>
                                <td>${{number_format($detalle->marzo,2)}}</td>
                                <td>${{number_format($detalle->abril,2)}}</td>
                                <td>${{number_format($detalle->mayo,2)}}</td>
                                <td>${{number_format($detalle->junio,2)}}</td>
                                <td>${{number_format($detalle->julio,2)}}</td>
                                <td>${{number_format($detalle->agosto,2)}}</td>
                                <td>${{number_format($detalle->septiembre,2)}}</td>
                                <td>${{number_format($detalle->octubre,2)}}</td>
                                <td>${{number_format($detalle->noviembre,2)}}</td>
                                <td>${{number_format($detalle->diciembre,2)}}</td>
                                <td>${{number_format($detalle->subtotal,2)}}</td>
                                <td>
                                  {{ Form::open(['route' => ['paacdetalles.destroy', $detalle->id ], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
                                  <a href="{{url('paacdetalles/'.$detalle->id.'/edit')}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                                  <button class="btn btn-danger btn-xs" type="button" onclick="
                                  return swal({
                                    title: 'Eliminar obra',
                                    text: '¿Está seguro de eliminar la obra?',
                                    type: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Si, Eliminar',
                                    cancelButtonText: 'No, Mantener',
                                    confirmButtonClass: 'btn btn-danger',
                                    cancelButtonClass: 'btn btn-default',
                                    buttonsStyling: false
                                  }).then(function(){
                                    submit();
                                  }, function(dismiss){
                                    if(dismiss == 'cancel'){
                                      swal('Cancelado', 'El registro se mantiene','info')
                                    }
                                  })" ; ><span class="glyphicon glyphicon-trash"></span></button>
                                  {{ Form::close()}}
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                              <tr>
                                  <th>Totales</th>
                                  <th>${{number_format($enero,2)}}</th>
                                  <th>${{number_format($febrero,2)}}</th>
                                  <th>${{number_format($marzo,2)}}</th>
                                  <th>${{number_format($abril,2)}}</th>
                                  <th>${{number_format($mayo,2)}}</th>
                                  <th>${{number_format($junio,2)}}</th>
                                  <th>${{number_format($julio,2)}}</th>
                                  <th>${{number_format($agosto,2)}}</th>
                                  <th>${{number_format($septiembre,2)}}</th>
                                  <th>${{number_format($octubre,2)}}</th>
                                  <th>${{number_format($noviembre,2)}}</th>
                                  <th>${{number_format($diciembre,2)}}</th>
                                  <th>${{number_format($total,2)}}</th>
                                  <th></th>
                              </tr>

                            </tfoot>
                          </table>
                        </div>


                </div>
            </div>
        </div>
    </div>

@endsection
