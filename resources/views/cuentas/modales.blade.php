<div class="modal fade" tabindex="-1" id="modal_registrar_cuenta" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar cuenta</h4>
      </div>
      <div class="modal-body">
          <form id="form_cuenta" action="" class="">
              @include('cuentas.formulario')
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_cuenta" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_cuentaproy" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar cuenta</h4>
      </div>
      <div class="modal-body">
          <form id="form_editarproyecto" action="" class="">
            @php
            $losbancos=\App\Banco::where('estado',1)->get();
            $bancos=[];
            foreach($losbancos as $banco){
                $bancos[$banco->id]=$banco->nombre;
            }
        @endphp
        
        
        
        <div class="form-group{{ $errors->has('numero_cuenta') ? ' has-error' : '' }}">
            <label for="numero_cuenta" class="control-label">Número de Cuenta</label>
            <div class="">
              
                {{ Form::number('numero_cuenta', null,['id'=>'num_cuenta','class' => 'form-control','step'=>'1']) }}
                @if ($errors->has('numero_cuenta'))
                <span class="help-block">
                    <strong>{{ $errors->first('numero_cuenta') }}</strong>
                </span>
                @endif
            </div>
        </div>
        
        
        
        <div class="form-group{{ $errors->has('banco_id') ? ' has-error' : '' }}">
            <label for="banco" class="control-label">Banco</label>
        
            <div class="">
                {{ Form::select('banco_id',$bancos, null,['id'=>'nomb_banco','class' => 'chosen-select-width','placeholder'=>'Seleccione un banco']) }}
                @if ($errors->has('banco'))
                <span class="help-block">
                    <strong>{{ $errors->first('banco') }}</strong>
                </span>
                @endif
            </div>
        </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="editar_cuentaproy" class="btn btn-primary">Editar</button>
      </div>
    </div>
  </div>
</div>



