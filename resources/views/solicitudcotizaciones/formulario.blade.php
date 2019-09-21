                <div class="form-group">
                    <label for="" class="col-md-4 control-label">Encargado\a del proceso: </label>
                    <div class="col-md-6">
                        {{Form::text('encargado',usuario(Auth()->user()->empleado_id),['readonly','class' => 'form-control', 'id' => 'encargado'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-4 control-label">Cargo: </label>
                    <div class="col-md-6">
                        {{Form::text('cargo',Auth()->user()->roleuser->role->description,['readonly','class' => 'form-control', 'id' => 'cargo'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-md-4 control-label">Proceso o proyecto: </label>
                    <div class="col-md-6">
                        {{Form::textarea('',$proyecto->nombre,['class' => 'form-control','rows'=>2,'readonly'])}}
                        {{Form::hidden('proyecto',$proyecto->id,['class' => 'form-control','id' => 'proyecto'])}}
                    </div>
                </div>

            

                <div class="form-group">
                    <label for="" class="col-md-4 control-label">Forma de pago: </label>
                    <div class="col-md-6">
                      <select name="formapago" id="formapago" class="chosen-select-width">
                          <option value="">Seleccione una forma de pago...</option>
                          @foreach ($formapagos as $forma)
                            <option value="{{$forma->id}}">{{$forma->nombre}}</option>
                          @endforeach   
                      </select>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#modalformapago"><span class="glyphicon glyphicon-plus"></span></button>
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-md-4 control-label">Unidad solicitante: </label>
                  <div class="col-md-6">
                      <select name="unidad" id="unidad" class="chosen-select-width">
                          <option value="">Seleccione una unidad administrativa</option>
                      </select>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#modalunidad"><span class="glyphicon glyphicon-plus"></span></button>
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
                
                <div class="form-group">
                    <label for="" class="control-label col-md-4">
                        Seleccione la categoría
                    </label>
                    <div class="col-md-6">
                        <select name="" id="filtrar_categoria" class="chosen-select-width"> 
                            <option value="0">Todos</option>
                            @foreach ($categorias  as $item)
                                <option value="{{$item->id}}">{{$item->nombre_categoria}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table class="table table-striped" id="tabla" display="block;">
                    <thead>
                        <tr>
                            <th width="5%"><input type="checkbox" checked id="todos">Todos</th>
                            
                            <th width="10%">N°</th>
                            <th width="50%">DESCRIPCIÓN</th>
                            <th width="10%"><center>UNIDAD DE MEDIDA</center></th>
                            <th width="10%"><center>CANTIDAD</center></th>
                            <th width="10%"><center>PRECIO UNITARIO</center></th>
                            <th width="5%">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo2">
                        @foreach($proyecto->presupuesto->presupuestodetalle as $key => $detalle)
                            @if($detalle->estado==1)
                            <tr>
                            <td><input type="checkbox" checked data-idcambiar="{{$detalle->id}}" data-material="{{$detalle->material_id}}" data-cantidad="{{$detalle->cantidad}}" class="lositemss"></td>
                                <td>{{$key+1}}</td>
                                <td>{{$detalle->material->nombre}}</td>
                                <td>{{$detalle->material->unidadmedida->nombre_medida}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
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
