                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-8">
                                {{ Form::text('nombre', null,['id'=>'nom_empleado','class' => 'form-control','autocomplete'=>'off']) }}
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
                            <label for="dui" class="col-md-4 control-label">Número de DUI</label>

                            <div class="col-md-8">
                                {{ Form::text('dui', null,['id' => 'dui_empleado','class' => 'form-control','data-inputmask' => '"mask": "99999999-9"','data-mask']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                            <label for="nit" class="col-md-4 control-label">Número de NIT</label>

                            <div class="col-md-8">
                                {{ Form::text('nit', null,['id'=>'nit_empleado','class' => 'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
                            <label for="sexo" class="col-md-4 control-label">Sexo</label>

                            <div class="col-md-1">
                                Másculino
                                {{ Form::radio('sexo', 'Másculino', false,['id' => 'masculino']) }}
                            </div>
                            <div class="col-md-1">
                                Femenino
                                {{ Form::radio('sexo', 'Femenino',false,['id' => 'femenino']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefono_fijo') ? ' has-error' : '' }}">
                            <label for="telefono_fijo" class="col-md-4 control-label">Teléfono fijo</label>

                            <div class="col-md-8">
                                {{ Form::text('telefono_fijo', null,['id' => 'fijo_empleado','class' => 'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                            <label for="celular" class="col-md-4 control-label">Teléfono celular</label>

                            <div class="col-md-8">
                                {{ Form::text('celular', null,['id'=>'cel_empleado','class' => 'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección</label>

                            <div class="col-md-8">
                                {{ Form::textarea('direccion', null,['id'=> 'dir_empleado','class' => 'form-control','rows' => 3,'autocomplete'=>'off']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                            <label for="fecha_nacimiento" class="col-md-4 control-label">Fecha de Nacimiento</label>

                            <div class="col-md-8">
                                {{Form::text('fecha_nacimiento', null,['class' => 'nacimiento form-control','id'=>'nacimimiento_empleado','autocomplete'=>'off'])}}
                            </div>
                        </div>
