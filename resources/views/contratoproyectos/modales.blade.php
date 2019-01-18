<div class="modal fade" data-backdrop="static" data-keyboard="false" id="form_proyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Ingreso Org
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                  {{Form::open(['id' => 'form_proy','class' => 'form-horizontal'])}}
                  @include('proyectos.formulario')
                  {{Form::close()}}
                </div>
                <div class="panel-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardar_proy">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
