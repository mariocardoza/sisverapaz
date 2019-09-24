<div class="modal fade" tabindex="-1" id="modal_indicador" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Registrar indicador</h4>
        </div>
        <div class="modal-body">
            <form id="form_indicador" action="" class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label class="control-label col-md-4">Nombre del indicador (*)</label>
                          <div class="col-md-6">
                              <input type="text" required id="nombre_indicador" class="form-control" placeholder="Nombre del indicador">
                          </div>       
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-4">Descripción (*)</label>
                          <div class="col-md-6">
                              <input type="text" required id="descripcion_indicador" class="form-control" placeholder="Digite la descripción del indicador">
                          </div>       
                      </div>
  
                      <div class="form-group">
                          <label class="control-label col-md-4">Porcentaje (*)</label>
                          <div class="col-md-6">
                              <input type="number" required id="porcentaje_indicador" min="1" max="100" step="1" class="form-control" placeholder="Digite el porcentaje que aplica">
                          </div>       
                      </div>
                    </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="agregar_indicador" class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" tabindex="-1" id="modal_indicador_e" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Editar indicador</h4>
        </div>
        <div class="modal-body">
          <form id="losdatos_e" action="" class="form-horizontal">
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label col-md-4">Nombre del indicador (*)</label>
                          <div class="col-md-6">
                              <input type="text" required id="nombre_indicador_e" class="form-control" placeholder="Nombre del indicador">
                              <input type="hidden" required id="elcodigo_e" class="form-control" placeholder="Nombre del indicador">
                          </div>       
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-4">Descripción (*)</label>
                          <div class="col-md-6">
                              <input type="text" required id="descripcion_indicador_e" class="form-control" placeholder="Digite la descripción del indicador">
                          </div>       
                      </div>
  
                      <div class="form-group">
                          <label class="control-label col-md-4">Porcentaje (*)</label>
                          <div class="col-md-6">
                              <input type="number" required id="porcentaje_indicador_e" min="1" max="100" step="1" class="form-control" placeholder="Digite el porcentaje que aplica">
                          </div>       
                      </div>
                  </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="agregar_indicador_e" class="btn btn-primary">Editar</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_subir_contrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Subir contrato</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['action'=>'ProyectoController@subircontrato', 'class' => '','id' => 'form_subircontrato','enctype'=>'multipart/form-data']) }}
              <input type="hidden" name="proyecto_id" value="{{$proyecto->id}}">
              <div class="form-group">
                <label for="" class="control-label">Nombre</label>
                <div>
                  <input type="text" class="form-control" name="nombre" autocomplete="off" placeholder="Nombre del contrato">
                </div>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Descripción</label>
                <div>
                  <input type="text" class="form-control" name="descripcion" autocomplete="off" placeholder="Nombre del contrato">
                </div>
              </div>
              <label for="file-upload" class="subir">
                <i class="glyphicon glyphicon-cloud"></i> Subir archivo
            </label>
            <input id="file-upload" onchange='cambiar()' name="archivo" type="file" style='display: none;'/>
            <div id="info3"></div>
                <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit"  class="btn btn-success">Guardar</button></center>
          {{Form::close()}}
        </div>
        <!--div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="agregar_orden" class="btn btn-success">Agregar</button></center>
        </div-->
      </div>
      </div>
</div>

<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_soli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Registrar la solicitud</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['class' => 'form-horizontal','id' => 'solicitudcotizacion']) }}
             
    
                      
          {{Form::close()}}
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="agregar_soli" class="btn btn-success">Agregar</button></center>
        </div>
      </div>
      </div>
    </div>
<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_pausar_proyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">¿Pausar el proyecto?</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['class' => '','id' => 'form_pausar']) }}
             <label for="" class="control-label">Motivo por el cual pausa el proyecto</label>
          <div>
            <textarea class="form-control" required name="motivo_pausa"></textarea>
            <input type="hidden" name="estado" value="9">
          </div>
                      
          {{Form::close()}}
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="pausar_proyecto" class="btn btn-success">Pausar</button></center>
        </div>
      </div>
      </div>
    </div>