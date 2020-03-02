<div class="row">
    <div class="col-md-12">

  @if(Auth()->user()->authorizeRoles(['admin','tesoreria']))
  <center><div class="form-group{{ $errors->has('es_usuario') ? ' has-error' : '' }}">
      <label for="es_usuario" class="control-label">¿Este empleado será usuario del sistema?</label>

      <div class="">
          No
          {{ Form::radio('es_usuario', 'no', true,['id' => 'no']) }}
          Si
          {{ Form::radio('es_usuario', 'si',false,['id' => 'si']) }}

      </div>
  </div>
  </center>
@endif
        
  <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
    <label for="nombre" class="control-label">Nombre</label>

    <div class="">
        {{ Form::text('nombre', null,['class' => 'form-control','autocomplete'=>'off']) }}
    </div>
</div>
      
</div>
<div class="col-md-6">
  <div class="form-group{{ $errors->has('dui') ? ' has-error' : '' }}">
    <label for="dui" class="control-label">Número de DUI</label>

    <div class="">
        {{ Form::text('dui', null,['class' => 'form-control dui']) }}
    </div>
  </div>

  <div class="form-group{{ $errors->has('sexo') ? ' has-error' : '' }}">
    <label for="sexo" class="control-label">Sexo</label>

    <div class="">
        Másculino
        {{ Form::radio('sexo', 'Másculino', false,['id' => 'masculino']) }}
        Femenino
        {{ Form::radio('sexo', 'Femenino',false,['id' => 'femenino']) }}

    </div>
  </div>

  <div class="form-group{{ $errors->has('telefono_fijo') ? ' has-error' : '' }}">
    <label for="telefono_fijo" class="control-label">Teléfono fijo</label>

    <div class="">
        {{ Form::text('telefono_fijo', null,['class' => 'form-control telefono','autocomplete'=>'off']) }}

    </div>
  </div>

  <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
    <label for="direccion" class="control-label">Dirección</label>

    <div class="">
        {{ Form::textarea('direccion', null,['class' => 'form-control','rows' => 3,'autocomplete'=>'off']) }}

    </div>
  </div>

</div>

<div class="col-md-6">
  <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
    <label for="nit" class="control-label">Número de NIT</label>

    <div class="">
        {{ Form::text('nit', null,['class' => 'form-control nit']) }}
    </div>
  </div>

  <div class="form-group{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
    <label for="fecha_nacimiento" class="control-label">Fecha de Nacimiento</label>

    <div class="">
    {{ Form::text('fecha_nacimiento', null,['class' => 'nacimiento form-control','autocomplete'=>'off']) }}
    </div>
  </div>
  <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
    <label for="celular" class="control-label">Teléfono celular</label>

    <div class="">
        {{ Form::text('celular', null,['class' => 'form-control telefono','autocomplete'=>'off']) }}

    </div>
  </div>

  <div class="form-group">
    <label for="" class="control-label">Email</label>
    <div class="">
        {{ Form::text('email', null,['class' => 'form-control','autocomplete'=>'off']) }}
    </div>
</div>
</div>
</div>