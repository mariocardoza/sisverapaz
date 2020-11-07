<?php 
  $categorias=\App\Categoria::categorias();
  $medidas=\App\UnidadMedida::medidas();
?>
<div class="form-group">
    <label class="control-label col-md-4">Nombre</label>
    <div class="col-md-6">
      
        {{Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Digite un nombre','autocomplete'=>'off'])}}
    </div>       
</div>

<div class="form-group">
    <label class="control-label col-md-4">Precio estimado</label>
    <div class="col-md-6">
      
        {{Form::number('precio_estimado',null,['class'=>'form-control','placeholder'=>'$0.00'])}}
    </div>       
</div>

<div class="form-group">
    <label class="control-label col-md-4">Categoría</label>
    <div class="col-md-6">
        {{ Form::select('categoria_id',$categorias, null,['placeholder'=>'Seleccione la categoría','class' => 'chosen-select-width']) }}
    </div>       
</div>

<div class="form-group">
    <label for="" class="control-label col-md-4">¿Es un servicio?</label>
    <div class="col-md-6">
        {!! Form::select('servicio',['0'=>'No','1'=>'Si'],null,['class'=>'chosen-select-width']) !!}
    </div>
</div>