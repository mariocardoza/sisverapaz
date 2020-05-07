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

<div class="modal fade" tabindex="-1" id="modal_mapainmueble" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Ubicación del inmueble</h4>
      </div>
      <div class="modal-body">
          <div id="elmapaimueble" style="height: 300px;"></div>
          
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </center>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_inmueble" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar un inmueble</h4>
      </div>
      <div class="modal-body">
          <form id="form_inmueble" class="">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="" class="control-label"># Catastral</label>
                    <input type="text" name="numero_catastral" autocomplete="off" placeholder="Digite el número catastral" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="control-label">Ancho inmueble (mts)</label>
                        <input type="number" name="ancho_inmueble" placeholder="Digite el ancho" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="control-label">Largo inmueble (mts)</label>
                        <input type="number" name="largo_inmueble" placeholder="Digite el largo" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="" class="control-label"># Escritura</label>
                    <input type="text" name="numero_escritura" autocomplete="off" placeholder="Digite el número de escritura" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="" class="control-label">Metros de acera</label>
                    <input type="text" name="metros_acera" autocomplete="off" placeholder="Digite la longitud de la acera (mts)" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <input type="hidden" name="lat" id="lat">
                  <input type="hidden" name="lng" id="lng">
                  <input type="hidden" name="direccion_inmueble" id="direcc">
                  <input type="hidden" name="contribuyente_id" id="contriid">

                  <div class="form-group">
                    <label for="" class="control-label">Dirección</label>
                    <h5 id="ladireccion"></h5>
                  </div>
                </div>
                <div class="col-md-12">
                  <div id="elmapitainmueble" style="height:350px;"></div>
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