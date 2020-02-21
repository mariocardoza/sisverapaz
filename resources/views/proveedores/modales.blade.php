<div class="modal fade" tabindex="-1" id="modal_representante" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar datos del presentante legal</h4>
      </div>
      <div class="modal-body">
      	{{ Form::model($proveedor, array('id' => 'form_representante')) }}
              <div class="form-group{{ $errors->has('nombrer') ? ' has-error' : '' }}">
                        <label for="nombrer" class="control-label">Nombre de Represetante</label>
                        <div class="">
                           {{ Form::text('nombrer', null,['class' => 'form-control']) }}
                           @if ($errors->has('nombrer'))
                           <span class="help-block">
                            <strong>{{ $errors->first('nombrer') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('telfijor') ? ' has-error' : '' }}">
                    <label for="telfijor" class="control-label">Telefono fijo Representante (si lo hay)</label>

                    <div class="">
                       {{ Form::text('telfijor', null,['class' => 'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask']) }}

                       @if ($errors->has('telfijor'))
                       <span class="help-block">
                        <strong>{{ $errors->first('telfijor') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('celular_r') ? ' has-error' : '' }}">
                <label for="celr" class="control-label">Celular Representante</label>

                <div class="">
                   {{ Form::text('celular_r', null,['class' => 'form-control','data-inputmask' => '"mask": "9999-9999"','data-mask']) }}

                   @if ($errors->has('celular_r'))
                   <span class="help-block">
                    <strong>{{ $errors->first('celular_r') }}</strong>
                </span>
                @endif
            </div>
            </div>

            <div class="form-group{{ $errors->has('duir') ? ' has-error' : '' }}">
                <label for="duir" class="control-label">DUI</label>

                <div class="">
                   {{ Form::email('duir', null,['class' => 'form-control','data-inputmask' => '"mask": "99999999-9"','data-mask']) }}
                   @if ($errors->has('duir'))
                   <span class="help-block">
                    <strong>{{ $errors->first('duir') }}</strong>
                </span>
                @endif
            </div>
          </div>

            <div class="form-group{{ $errors->has('emailr') ? ' has-error' : '' }}">
                <label for="emailr" class="control-label">E-mail representante</label>

                <div class="">
                   {{ Form::email('emailr', null,['class' => 'form-control']) }}
                   @if ($errors->has('emailr'))
                   <span class="help-block">
                    <strong>{{ $errors->first('emailr') }}</strong>
                </span>
                @endif
            </div>
          </div>
      	</form>
      </div>
      <div class="modal-footer">
        <center>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_representante" class="btn btn-primary">Registrar</button></center>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="modal_proveedor" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Editar datos del proveedor</h4>
      </div>
      <div class="modal-body">
        {{ Form::model($proveedor, array('id' => 'form_proveedor')) }}
          @include('proveedores.formulario')
        </form>
      </div>
      <div class="modal-footer">
        <center>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="editar_proveedor" class="btn btn-primary">Registrar</button></center>
      </div>
    </div>
  </div>
</div>