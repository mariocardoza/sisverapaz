                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                {{ Form::text('nombre', null,['id'=>'nom_empleado','class' => 'form-control','autocomplete'=>'off']) }}
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
                            <label for="dui" class="col-md-4 control-label">Número de DUI</label>

                            <div class="col-md-6">
                                {{ Form::text('dui', null,['id' => 'dui_empleado','class' => 'form-control','data-inputmask' => '"mask": "99999999-9"','data-mask']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                            <label for="nit" class="col-md-4 control-label">Número de NIT</label>

                            <div class="col-md-6">
                                {{ Form::text('nit', null,['id'=>'nit_empleado','class' => 'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
                            <label for="sexo" class="col-md-4 control-label">Sexo</label>

                            <div class="col-md-6">
                                Másculino
                                {{ Form::radio('sexo', 'Másculino', false,['id' => 'masculino']) }}
                                Femenino
                                {{ Form::radio('sexo', 'Femenino',false,['id' => 'femenino']) }}

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                {{ Form::text('email', null,['id'=>'email_empleado','class' => 'form-control','autocomplete'=>'off']) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('es_usuario') ? ' has-error' : '' }}">
                            <label for="es_usuario" class="col-md-4 control-label">¿Será usuario del sistema?</label>

                            <div class="col-md-6">
                                No
                                {{ Form::radio('es_usuario', 'no', true,['id' => 'no']) }}
                                Si
                                {{ Form::radio('es_usuario', 'si',false,['id' => 'si']) }}

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefono_fijo') ? ' has-error' : '' }}">
                            <label for="telefono_fijo" class="col-md-4 control-label">Teléfono fijo</label>

                            <div class="col-md-6">
                                {{ Form::text('telefono_fijo', null,['id' => 'fijo_empleado','class' => 'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask']) }}

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                            <label for="celular" class="col-md-4 control-label">Teléfono celular</label>

                            <div class="col-md-6">
                                {{ Form::text('celular', null,['id'=>'cel_empleado','class' => 'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask']) }}

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección</label>

                            <div class="col-md-6">
                                {{ Form::textarea('direccion', null,['id'=> 'dir_empleado','class' => 'form-control','rows' => 3,'autocomplete'=>'off']) }}

                            </div>
                        </div>

                        <div class="form-group">
							      		    <label class="col-md-4 control-label{{ $errors->has('departamento') ? ' has-error' : '' }}">Departamento</label>
										        <div class="col-md-2">
											         <select class="chosen-select-width" name="departamento" id="departamento" onChange="SelectSubCat(departamento, municipio);">
											  	        <option value="0">Seleccione...</option>
												          <option value="Ahuachapán">Ahuachapán</option>
												          <option value="Cabañas">Cabañas</option>
												          <option value="Chalatenango">Chalatenango</option>
												          <option value="Cuscatlán">Cuscatlán</option>
												          <option value="La Libertad">La Libertad</option>
												          <option value="La Paz">La Paz</option>
												          <option value="La Unión">La Unión</option>
												          <option value="Morazán">Morazán</option>
												          <option value="San Miguel">San Miguel</option>
												          <option value="San Salvador">San Salvador</option>
												          <option value="San Vicente">San Vicente</option>
												          <option value="Santa Ana">Santa Ana</option>
												          <option value="Sonsonate">Sonsonate</option>
												          <option value="Usulután">Usulután</option>
											        </select>
										       </div>
										       <label class="col-md-1 control-label{{ $errors->has('municipio') ? ' has-error' : '' }}">Municipio</label>
										          <div class="col-md-3">
											           <select class="chosen-select-width" id="municipio" name="municipio">
											  	       <option value="">Seleccione...</option>
											        </select>
										    </div>
							     </div>


                   <div class="form-group{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                     <label for="fecha_nacimiento" class="col-md-4 control-label">Fecha de Nacimiento</label>

                     <div class="col-md-6">
                       {{ Form::text('fecha_nacimiento', null,['class' => 'nacimiento form-control', 'id' => 'fecha_nacimiento']) }}
                     </div>
                   </div>


                        <div class="form-group{{ $errors->has('num_cuenta') ? ' has-error' : '' }}">
                            <label for="num_cuenta" class="col-md-4 control-label">Número de cuenta bancaria</label>

                            <div class="col-md-6">
                                {{ Form::text('num_cuenta', null,['id'=>'cuenta_empleado','class' => 'form-control','data-inputmask' => '"mask": "999999999999"','data-mask']) }}

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('num_contribuyente') ? ' has-error' : '' }}">
                            <label for="num_contribuyente" class="col-md-4 control-label">Número de contribuyente</label>

                            <div class="col-md-6">
                                {{ Form::text('num_contribuyente', null,['id'=>'contri_empleado','class' => 'form-control','data-inputmask' => '"mask": "999-9"','data-mask']) }}

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('num_seguro_social') ? ' has-error' : '' }}">
                            <label for="num_seguro_social" class="col-md-4 control-label">Número de Seguro Social</label>

                            <div class="col-md-6">
                                {{ Form::text('num_seguro_social', null,['id'=>'seguro_empleado','class' => 'form-control','data-inputmask' => '"mask": "999999999"','data-mask']) }}

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('num_afp') ? ' has-error' : '' }}">
                            <label for="num_afp" class="col-md-4 control-label">Número único previsional</label>

                            <div class="col-md-6">
                                {{ Form::text('num_afp', null,['id'=>'afp_empleado','class' => 'form-control','data-inputmask' => '"mask": "999999999999"','data-mask']) }}

                            </div>
                        </div>
