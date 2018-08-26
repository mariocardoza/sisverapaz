                      <div class="form-group">
                        <label for="" class="col-md-4 control-label">Actividad</label>
                        <div class="col-md-6">
                          {!! Form::textarea('',null,['id'=>'actividad','class' => 'form-control','placeholder'=>'Digite la actividad a realizar','rows'=>3]) !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="" class="col-md-4 control-label">Unidad Solicitante</label>
                        <div class="col-md-6">
                          {{Form::text('',Auth()->user()->cargo,['class'=>'form-control','readonly'])}}
                        </div>
                      </div>

                        <div class="form-group">
                          <label for="" class="col-md-4 control-label">Responsable</label>
                            <div class="col-md-6">
                              {{Form::hidden('',Auth()->user()->id,['id'=>'user_id'])}}
                              {!!Form::text('',Auth()->user()->empleado->nombre,['class' => 'form-control','readonly'])!!}
                            </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="col-md-4 control-label">Observaciones</label>
                            <div class="col-md-6">
                              {!!Form::textarea('',null,['id'=>'observaciones','class' => 'form-control','rows' => 3])!!}
                            </div>
                        </div>
