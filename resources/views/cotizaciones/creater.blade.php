@extends('layouts.app')

@section('migasdepan')
      <h1>
        Cotización
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/solicitudcotizaciones') }}"><i class="fa fa-balance-scale"></i> Solicitud</a></li>
        <li class="active">Registro</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de cotizaciones</div>
                <div class="panel-body">
                    {{ Form::open(['action'=> 'CotizacionController@store', 'class' => 'form-horizontal']) }}

                    <div class="form-group{{ $errors->has('proveedor') ? ' has-error' : '' }}">
                        <label for="" class="col-md-4 control-label">Proveedor</label>
                        <div class="col-md-6">
                            <select name="proveedor" id="proveedor" class="chosen-select-width">
                                <option value="">Seleccione un proveedor</option>
                                @foreach($proveedores as $proveedor)
                                <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalproveedor"><span class="glyphicon glyphicon-plus"></span></button>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                        <label for="descripcion" class="col-md-4 control-label">Forma de pago</label>

                        <div class="col-md-6">
                            {!!Form::hidden('id',$solicitud->id,['id'=>'id'])!!}
                            <select class="chosen-select-width" name="descripcion" id="formapago">
                              <option value="">Seleccione una forma de pago</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalformapago"><span class="glyphicon glyphicon-plus"></span></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped" id="tabla" display="block;">
                          <thead>
                              <tr>
                                  <th width="50%">Descripción</th>
                                  <th width="10%">Unidad de medida</th>
                                  <th width="10%">Cantidad</th>
                                  <th width="10%">Marca</th>
                                  <th width="10%">Precio unitario</th>
                                  <th width="10%">Total</th>
                              </tr>
                          </thead>
                          <tbody id="cuerpo">
                            @foreach($solicitud->requisicion->requisiciondetalle as $detalle)
                              <tr>
                                <td>{{$detalle->descripcion}}</td>
                                <td>{{$detalle->unidad_medida}}</td>
                                <td>{{$detalle->cantidad}}
                                  <input type='hidden' name='unidades[]' value='{{$detalle->unidad_medida}}'/>
                                  <input type='hidden' name='descripciones[]' value='{{$detalle->descripcion}}'/>
                                  <input type='hidden' name='cantidades[]' value='{{$detalle->cantidad}}'/>
                                </td>
                                <td><input type="text" name="marcas[]" class="marcas form-control"/></td>
                                <td><input name="precios[]" data-cantidad={{$detalle->cantidad}} type="number" min="0.01" step="any" class="precios form-control"/></td>
                                <td class="subtotal">$0.00</td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="button" id="btnguardar" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk">Registrar</span>
                            </button>
                        </div>

                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalformapago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Registrar una forma de pago
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    @include('formapagos.formulario')
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarformapago" class="btn btn-success">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
{{Html::script('js/cotizacion.js')}}
@endsection
