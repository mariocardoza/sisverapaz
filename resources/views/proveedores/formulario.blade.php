<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Datos del Proveedor (Obligatorio)
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">

       <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
        <label for="nombre" class="col-md-4 control-label">Nombre de la Empresa o Proveedor</label>
        <div class="col-md-6">
            {{ Form::text('nombre', null,['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
        <label for="direccion" class="col-md-4 control-label">Dirección</label>

        <div class="col-md-6">
         {{ Form::textarea('direccion', null,['class' => 'form-control','rows'=>2]) }}
    </div>
</div>

        <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
            <label for="telefono" class="col-md-4 control-label">Teléfono</label>

            <div class="col-md-6">
             {{ Form::text('telefono', null,['class' => 'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask']) }}
        </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail Proveedor</label>

            <div class="col-md-6">
               {{ Form::email('email', null,['class' => 'form-control']) }}
            </div>
        </div>
          <div class="form-group{{ $errors->has('numero_registro') ? ' has-error' : '' }}">
              <label for="numero_registro" class="col-md-4 control-label">Número de registro del proveedor</label>

              <div class="col-md-6">
                  {{ Form::text('numero_registro', null,['class' => 'form-control']) }}
              </div>
          </div>
          <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
              <label for="numero_registro" class="col-md-4 control-label">DUI (Si es persona natural)</label>

              <div class="col-md-6">
                  {{ Form::text('dui', null,['class' => 'form-control','data-inputmask' => '"mask": "99999999-9"','data-mask']) }}
              </div>
          </div>
          <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
              <label for="nit" class="col-md-4 control-label">Número de NIT</label>

              <div class="col-md-6">
                  {{ Form::text('nit', null,['class' => 'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask']) }}
              </div>
          </div>
      </div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Datos del Representante legal (Opcional)
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
                    <div class="form-group{{ $errors->has('nombrer') ? ' has-error' : '' }}">
                        <label for="nombrer" class="col-md-4 control-label">Nombre de Represetante</label>
                        <div class="col-md-6">
                           {{ Form::text('nombrer', null,['class' => 'form-control']) }}
                           @if ($errors->has('nombrer'))
                           <span class="help-block">
                            <strong>{{ $errors->first('nombrer') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('telfijor') ? ' has-error' : '' }}">
                    <label for="telfijor" class="col-md-4 control-label">Telefono fijo Representante (si lo hay)</label>

                    <div class="col-md-6">
                       {{ Form::text('telfijor', null,['class' => 'form-control']) }}

                       @if ($errors->has('telfijor'))
                       <span class="help-block">
                        <strong>{{ $errors->first('telfijor') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('celular_r') ? ' has-error' : '' }}">
                <label for="celr" class="col-md-4 control-label">Celular Representante</label>

                <div class="col-md-6">
                   {{ Form::text('celular_r', null,['class' => 'form-control']) }}

                   @if ($errors->has('celular_r'))
                   <span class="help-block">
                    <strong>{{ $errors->first('celular_r') }}</strong>
                </span>
                @endif
            </div>
            </div>

            <div class="form-group{{ $errors->has('emailr') ? ' has-error' : '' }}">
                <label for="emailr" class="col-md-4 control-label">E-mail representante</label>

                <div class="col-md-6">
                   {{ Form::email('emailr', null,['class' => 'form-control']) }}
                   @if ($errors->has('emailr'))
                   <span class="help-block">
                    <strong>{{ $errors->first('emailr') }}</strong>
                </span>
                @endif
            </div>
            </div>
      </div>
    </div>
  </div>
</div>
