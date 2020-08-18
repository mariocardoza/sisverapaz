@php
    $gis=\App\Giro::where('estado',1)->get();
    $giros=[];
    foreach($gis as $g){
      $giros[$g->id]=$g->nombre;
    }
@endphp
    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre" class="control-label">Nombre de la Empresa o Proveedor</label>
                {{ Form::text('nombre', null,['class' => 'form-control','autocomplete'=>'off']) }}
        </div>

        <div class="">
            <label for="direccion" class="control-label">Dirección</label>
    
             {{ Form::textarea('direccion', null,['class' => 'form-control','rows'=>2,'autocomplete'=>'off']) }}
        </div>

        <div class="form-group">
            <label for="email" class="control-label">E-Mail</label>

               {{ Form::email('email', null,['class' => 'form-control','autocomplete'=>'off']) }}
        </div>

        <div class="form-group">
            <label for="numero_registro" class="control-label">DUI (Si es persona natural)</label>

                {{ Form::text('dui', null,['class' => 'form-control dui','autocomplete'=>'off']) }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre" class="control-label">Giro</label>
                {{ Form::select('giro_id',$giros, null,['class' => 'chosen-select-width','placeholder'=>'Seleccione un giro']) }}
        </div>

        <div class="form-group">
            <label for="telefono" class="control-label">Teléfono</label>

             {{ Form::text('telefono', null,['class' => 'form-control telefono','autocomplete'=>'off']) }}
        </div>

        <div class="form-group">
            <label for="numero_registro" class="control-label">Número de registro</label>

                {{ Form::text('numero_registro', null,['class' => 'form-control','autocomplete'=>'off']) }}
        </div>

        <div class="form-group">
            <label for="nit" class="control-label">Número de NIT</label>

                {{ Form::text('nit', null,['class' => 'form-control nit','autocomplete'=>'off']) }}
        </div>
    </div>

       

    

  

        

        
          
          
        
  

