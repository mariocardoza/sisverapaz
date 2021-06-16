                        <div class="form-group">
                          <label for="" class="col-md-4">Proyecto</label>
                            <div class="col-md-6">
                              @if(isset($proyectos))
                                <select id="proyecto" class="chosen-select-width">
                                    <option value="">Seleccione un Proyecto...</option>
                                    @foreach($proyectos as $proyecto)
                                      <option data-monto="{{$proyecto->monto}}" value="{{$proyecto->id}}">{{$proyecto->nombre}}</option>
                                    @endforeach
                                </select>
                              @else
                                {!!Form::hidden('',$proyecto->id,['id' => 'proyecto'])!!}
                                {!! Form::hidden('',$proyecto->monto,['id' => 'monto']) !!}
                                {!!Form::textarea('',$proyecto->nombre,['class' => 'form-control','readonly','rows'=>3])!!}
                              @endif
                            </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="col-md-4">Item</label>
                          <div class="col-md-6">
                            {{Form::hidden('',$item1->id,['id' => 'itemid'])}}
                            {{Form::text('',$item1->item .' '. $item1->nombre_categoria,['class' => 'form-control'])}}
                          </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-md-4">Descripción</label>
                            <div class="col-md-6">
                              <select class="chosen-select-width" id="catalogo">
                                <option value="">Seleccione una descripción</option>
                              </select>
                            </div>
                            <div class="col-md-2">
                              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalcatalogo"><span class="glyphicon glyphicon-plus"></span></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-4">Digite la cantidad que necesita</label>
                            <div class="col-md-6">
                                <input type="number" min="1" steps="1" id="cantidad" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-4">Digite el precio unitario</label>
                            <div class="col-md-6">
                                <input type="number" min="1" steps=".01" id="precio" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                              <button type="button" id="agregaratabla" class="btn btn-success">Agregar</button>
                            </div>
                        </div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalcatalogo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Ingreso de Categoría
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                      <label for="" class="col-md-4">Item</label>
                      <div class="col-md-6">
                        {{Form::hidden('',$item1->id,['id' => 'categoria_id'])}}
                        {{Form::text('',$item1->item .' '. $item1->nombre_categoria,['class' => 'form-control'])}}

                      </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4">Digite una opción</label>
                        <div class="col-md-6">
                                <input type="text" id="txtdescripcion" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4">Unidad de medida</label>
                        <div class="col-md-6">
                            <select class="chosen-select-width" id="txtunidad">
                              <option value="">Seleccione una unidad de medida</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUnidades"><span class="glyphicon glyphicon-plus"></span></button>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarcatalogo" data-dismiss="modal" class="btn btn-success">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalUnidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Ingreso de unidad de medida
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="" class="col-md-4">Digite una unidad de medida</label>
                        <div class="col-md-6">
                            <input type="text" id="txtnombreunidades" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarunidades" class="btn btn-success">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>
