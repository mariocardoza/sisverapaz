<form id="form_jornada" class="">
    <div class="form-group">
            <label for="name" class="control-label">Fecha de inicio</label>
        
        
            <div class="">
              
                {!!Form::text('fecha_inicio',null, ['class'=>'form-control', 'id'=>'fecha_inicio','autocomplete'=>'off'])!!}
             
            </div>
        </div>
        
        <div class="form-group">
            <label for="name" class="control-label">Fecha de finalización</label>
            <div class="">
                {!!Form::text('fecha_fin',null, ['class'=>'form-control', 'id'=>'fecha_fin','autocomplete'=>'off'])!!}
              {!!Form::hidden('proyecto_id',$proyecto->id,['class'=>'form-control'])!!}
            </div>
        </div>


<center>
    <button class="btn btn-primary" id="btn_guardarjornada" type="button">Guardar</button>
    <button class="btn btn-danger" id="btn_cancelarjornada" type="button">Cancelar</button>
</center>
</form>