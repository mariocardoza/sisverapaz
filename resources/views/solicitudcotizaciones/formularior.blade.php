                <div class="form-group">
                    <label for="" class="col-md-4 control-label">Encargado\a del proceso: </label>
                    <div class="col-md-6">
                        {{Form::text('encargado',usuario(Auth()->user()->empleado_id),['readonly','class' => 'form-control', 'id' => 'encargado'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                      {{Form::text('cargo',vercargo(Auth()->user()->cargo),['readonly','class' => 'form-control', 'id' => 'cargo'])}}
                        {{Form::hidden('unidad',$requisicion->user->cargo,['readonly','class' => 'form-control', 'id' => 'unidad'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-4 control-label">Actividad: </label>
                    <div class="col-md-6">
                        {{Form::textarea('',$requisicion->actividad,['class' => 'form-control','rows'=>2,'readonly'])}}
                        {{Form::hidden('requisicion',$requisicion->id,['class' => 'form-control','id' => 'requisicion'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-4 control-label">Forma de pago: </label>
                    <div class="col-md-6">
                      <select name="formapago" id="formapago" class="chosen-select-width">
                          <option value="">Seleccione una forma de pago...</option>
                      </select>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#modalformapago"><span class="glyphicon glyphicon-plus"></span></button>
                  </div>
              </div>

                <div class="form-group{{ $errors->has('lugar_entrega') ? ' has-error' : '' }}">
                    <label for="lugar_entrega" class="col-md-4 control-label">Lugar de entrega de los suministros</label>

                    <div class="col-md-6">
                        {!!Form::textarea('lugar_entrega',null,['class'=>'form-control','id'=>'lugar_entrega','rows'=>2])!!}
                    </div>
                </div>

                <div class="form-group">
                  <label for="fecha_limite" class="col-md-4 control-label">Fecha limite para cotizar</label>
                  <div class="col-md-6">
                    {!!Form::text('fecha_limite',null,['class' => 'form-control unafecha','id'=>'fecha_limite'])!!}
                  </div>
                </div>

                <div class="form-group">
                  <label for="tiempo_entrega" class="col-md-4 control-label">Tiempo de entrega</label>
                  <div class="col-md-6">
                    {!!Form::text('tiempo_entrega',null,['class' => 'form-control','id'=>'tiempo_entrega'])!!}
                  </div>
                </div>

                <table class="table table-striped" id="tabla" display="block;">
                    <thead>
                        <tr>
                            <th width="10%">ÍTEM</th>
                            <th width="50%">DESCRIPCIÓN</th>
                            <th width="10%"><center>UNIDAD DE MEDIDA</center></th>
                            <th width="10%"><center>CANTIDAD</center></th>
                            <th width="10%"><center>PRECIO UNITARIO</center></th>
                            <th width="10%">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($requisicion->requisiciondetalle as $key => $detalle)
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$detalle->descripcion}}</td>
                          <td>{{$detalle->unidad_medida}}</td>
                          <td>{{$detalle->cantidad}}</td>
                          <td></td>
                          <td></td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>

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

                <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalunidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="row">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Registrar una forma de pago
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="panel-body">
                                    @include('unidades.formulario')
                                </div>
                                <div class="panel-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="button" id="guardarunidad" class="btn btn-success">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
