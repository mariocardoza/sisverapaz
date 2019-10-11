

       <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
        <label for="nombre" class="control-label">Nombre de la Empresa o Proveedor</label>
        <div class="">
            {{ Form::text('nombre', null,['class' => 'form-control','autocomplete'=>'off']) }}
        </div>
    </div>

    <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
        <label for="direccion" class="control-label">Dirección</label>

        <div class="">
         {{ Form::textarea('direccion', null,['class' => 'form-control','rows'=>2,'autocomplete'=>'off']) }}
    </div>
</div>

        <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
            <label for="telefono" class="control-label">Teléfono</label>

            <div class="">
             {{ Form::text('telefono', null,['class' => 'form-control telefono','autocomplete'=>'off']) }}
        </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label">E-Mail Proveedor</label>

            <div class="">
               {{ Form::email('email', null,['class' => 'form-control','autocomplete'=>'off']) }}
            </div>
        </div>
          <div class="form-group{{ $errors->has('numero_registro') ? ' has-error' : '' }}">
              <label for="numero_registro" class="control-label">Número de registro del proveedor</label>

              <div class="">
                  {{ Form::text('numero_registro', null,['class' => 'form-control','autocomplete'=>'off']) }}
              </div>
          </div>
          <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
              <label for="numero_registro" class="control-label">DUI (Si es persona natural)</label>

              <div class="">
                  {{ Form::text('dui', null,['class' => 'form-control dui','autocomplete'=>'off']) }}
              </div>
          </div>
          <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
              <label for="nit" class="control-label">Número de NIT</label>

              <div class="">
                  {{ Form::text('nit', null,['class' => 'form-control nit','autocomplete'=>'off']) }}
              </div>
          </div>
  

