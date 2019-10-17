<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_unidadmedida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Registrar unidad de medida</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['class' => '','id' => 'form_medida']) }}
              
            <div class="form-group">
                <label for="" class="control-label">Unidad de medida</label>
                <div class="">
                    <input type="text" name="nombre_medida" autocomplete="off" id="este" class="form-control">
            </div>

            </div>        
          {{Form::close()}}
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" id="registrar_medida" class="btn btn-primary">Registrar</button></center>
        </div>
      </div>
      </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_eunidadmedida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registrar unidad de medida</h4>
    </div>
    <div class="modal-body">
        {{ Form::open(['class' => '','id' => 'form_emedida']) }}
            
        <div class="form-group">
            <label for="" class="control-label">Unidad de medida</label>
            <div class="">
                <input type="text" name="nombre_medida" autocomplete="off" id="este2" class="form-control">
        </div>
        </div>
                    
        {{Form::close()}}
    </div>
    <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="editar_medida" class="btn btn-primary">Editar</button></center>
    </div>
    </div>
    </div>
</div>