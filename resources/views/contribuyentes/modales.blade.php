<div class="modal fade" tabindex="-1" id="modal_rubros" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Rubros</h4>
        </div>
        <div class="modal-body">
            <form id="form_rubro" action="" class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-primary" id="nuevo_rubro" title='Agregar nuevo rubro'>
                                <i class="fa fa-plus-circle"></i>
                            </button>
                        </div>
                        <table class="table tbrubro" id="example2">
                            <thead>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Porcentaje</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></center>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_servicios" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Servicios</h4>
      </div>
      <div class="modal-body">
          <form id="form_servicio" action="" class="form-horizontal">
              <div class="row">
                  <div class="col-md-12">
                      <div class="btn-group pull-right">
                          <button type="button" class="btn btn-primary" id="nuevo_servicio" title='Agregar nuevo servicio'>
                              <i class="fa fa-plus-circle"></i>
                          </button>
                      </div>
                      <table class="table tbservicio" id="example2">
                          <thead>
                              <th>N°</th>
                              <th>Nombre</th>
                              <th>Costo</th>
                              <th>Tipo cobro</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                          </thead>
                          <tbody>

                          </tbody>
                      </table>
                  </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></center>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_contribuyente" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar nuevo contribuyente</h4>
      </div>
      <div class="modal-body">
          <form id="form_contribuyente" class="">
              <div class="row">
                  <div class="col-md-12">
                    @include('contribuyentes.formulario')
                  </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Registrar</button></center>
      </div>
    </form>
    </div>
  </div>
</div>