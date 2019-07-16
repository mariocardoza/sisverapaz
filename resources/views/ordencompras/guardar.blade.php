@extends('layouts.app')

@section('migasdepan')
    <h1>
        Ordenes de compra
    </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/ordencompras') }}"><i class="fa fa-dashboard"></i> Ordenes de compra</a></li>
        <li class="active">Registro</li>
      </ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Orden de compra</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'OrdencompraController@guardar','class' => 'form-horizontal']) }}
                    @include('errors.validacion')

                    <div class="form-group{{ $errors->has('proyecto') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-md-4 control-label">Nombre de la actividad</label>

                        <div class="col-md-6">
                          {{Form::hidden('',$cotizacion->id,['id'=>'cotizacion_id'])}}
                            {!!Form::textarea('actividad',$cotizacion->solicitudcotizacion->requisicion->actividad,['rows'=>3,'class' => 'form-control','placeholder' => 'Digite la actividad','readonly'])!!}
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('proveedor') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-md-4 control-label">Nombre del proveedor</label>

                        <div class="col-md-6">
                          {{Form::text('',$cotizacion->proveedor->nombre,['class'=>'form-control','readonly'])}}
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-md-4 control-label">Condiciones de pago</label>

                        <div class="col-md-6">
                          {{Form::text('',$cotizacion->formapago->nombre,['class'=>'form-control','readonly'])}}
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('adminorden') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-md-4 control-label">Nombre del administrador de la orden</label>
                        <div class="col-md-6">
                            {!!Form::text('adminorden',$cotizacion->solicitudcotizacion->requisicion->user->empleado->nombre,['class'=>'form-control','id'=>'adminorden','readonly'])!!}
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-md-4 control-label">Dirección de entrega</label>

                        <div class="col-md-6">
                            {!!Form::textarea('direccion_entrega',null,['rows' => 3,'class'=>'form-control','id'=>'direccion_entrega','placeholder'=>'Digite la direccion de entrega de los materiales'])!!}
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-md-4 control-label">Periodo de entrega</label>

                        <div class="col-md-2">
                            {!!Form::text('fecha_inicio',null,['class'=>'form-control','id'=>'fecha_inicio','placeholder'=>'Fecha de inicio'])!!}
                        </div>
                        <div class="col-md-1"><label for="">al</label></div>
                        <div class="col-md-2">
                            {!!Form::text('fecha_fin',null,['class'=>'form-control','id'=>'fecha_fin','placeholder'=>'Fecha de finalizacion'])!!}
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-md-4 control-label">Observaciones</label>

                        <div class="col-md-6">
                            {!!Form::textarea('observaciones',null,['id'=>'observaciones','rows'=>2,'class'=>'form-control','placeholder'=>'Digite las observaciones (si las hay)'])!!}
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="">
                            <thead>
                                <tr>
                                    <th width="5%">N°</th>
                                    <th width="40%">Descripcion</th>
                                    <th width="10%">Marca</th>
                                    <th width="10%">Unidad de medida</th>
                                    <th width="10%">Cantidad</th>
                                    <th width="10%">Precio Unitario</th>
                                    <th width="15%">Subtotal</th>
                                </tr>
                                <?php $total=0.0; ?>
                            </thead>
                            <tbody id="cuerpo">
                              @foreach($cotizacion->detallecotizacion as $key => $detalle)
                                <?php $total=$total+$detalle->precio_unitario*$detalle->cantidad;?>
                                <tr>
                                  <td>{{$key+1}}</td>
                                  <td>{{$detalle->descripcion}}</td>
                                  <td>{{$detalle->marca}}</td>
                                  <td>{{$detalle->unidad_medida}}</td>
                                  <td>{{$detalle->cantidad}}</td>
                                  <td>${{number_format($detalle->precio_unitario,2)}}</td>
                                  <td>${{number_format($detalle->precio_unitario*$detalle->cantidad,2)}}</td>
                                </tr>
                              @endforeach
                            </tbody>
                            <tfoot id="pie">
                                <tr>
                                  <th colspan="6">Total en letras: {{numaletras($total)}} </th>
                                  <th>${{number_format($total,2)}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-1">
                            <button type="button" id="btnguardar" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>Registrar
                            </button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('scripts')
{!! Html::script('js/ordencompra.js')!!}
@endsection
