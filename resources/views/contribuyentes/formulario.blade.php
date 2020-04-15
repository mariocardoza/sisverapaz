<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
            <label for="nombre" class="control-label">Nombre completo</label>
        
            <div class="">
                {{ Form::text('nombre', null,['class' => 'form-control','autocomplete'=>'off']) }}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
            <label for="dui" class="control-label">Número de DUI</label>
        
            <div class="">
                {{ Form::text('dui', null,['class' => 'form-control','data-inputmask' => '"mask": "99999999-9"','data-mask']) }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
            <label for="nit" class="control-label">Número de NIT</label>
        
            <div class="">
                {{ Form::text('nit', null,['class' => 'form-control','data-inputmask' => '"mask": "9999-999999-999-9"','data-mask']) }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
            <label for="telefono" class="control-label">Teléfono</label>
        
            <div class="">
                {{ Form::text('telefono', null,['class' => 'form-control telefono']) }}
            </div>
        </div>
        
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('nacimiento') ? ' has-error' : '' }}">
            <label for="nacimiento" class="control-label">Fecha de Nacimiento</label>
        
            <div class="">
                
                {{ Form::text('nacimiento',null, ['class' => 'form-control nacimiento','autocomplete'=>'off']) }}
              
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
            <label for="sexo" class="control-label">Sexo</label>
        
            <div class="">
                <select name="sexo" id="" class="chosen-select-width">
                    <option value="">Seleccione</option>
                    <option value="Másculino">Másculino</option>
                    <option value="Femenino">Femenido</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
            <label for="direccion" class="control-label">Dirección</label>
        
            <div class="">
                {{ Form::textarea('direccion', null,['class' => 'form-control','rows' => 3,'autocomplete'=>'off']) }}
            </div>
        </div>
    </div>
</div>
