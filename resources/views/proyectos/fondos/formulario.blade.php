                        <div class="form-group">
                          <center><label for="" class="col-md-12">Fondos del Proyecto</label></center>
                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="" class="col-md-4 control-label">Fuente</label>

                                <div class="col-md-6">
                                  <select class="chosen-select-width" id="cat_id">
                                    <option value="">Seleccione Fuente</option>
                                  </select>
                                </div>
                                <div class="col-md-2">
                                  <button type="button" class="btn btn-primary" name="button" id="" data-toggle="modal" data-target="#modalcategoria"><span class="glyphicon glyphicon-plus"></span></button>
                                </div>
                        </div>

                          <div class="form-group">
                            <label for="" class="col-md-4 control-label">Ingrese el monto</label>
                            <div class="col-md-6">
                              <input type="number" id="cant_monto" class="form-control" step="0.00" min="0.00">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" type="button" id="btnAgregar">Agregar</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fecha_fin" class="col-md-4 control-label"></label>

                            <div class="col-md-6">
                                <table class="table table-striped table-bordered" id="tbFondos">
                                    <thead>
                                    <tr>
                                        <th>Fuente</th>
                                        <th>Cantidad</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cuerpo_fondos"></tbody>
                                    <tfoot id="pie_monto">
                                        <tr>
                                            <td class="text-left" >Total $</td>
                                            <td style="text-align:right;" id="totalEnd">0.00</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
