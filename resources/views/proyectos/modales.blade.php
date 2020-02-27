@php
    $lescargos=App\CargoProyecto::where('estado',1)->get();
    $cargos=$proveedores=[];
    foreach($lescargos as $i){
      $cargos[$i->id]=$i->nombre;
    }
    $elpro=$proyecto->id;
    $lesproveedores=DB::table('proveedors as p')
                  ->select('p.*')
                    ->whereNotExists(function ($query) use ($elpro)  {
                         $query->from('licitacions')
                            ->whereRaw('licitacions.proveedor_id = p.id')
                            ->whereRaw('licitacions.proyecto_id ='.$elpro);
                        })->get();
    foreach($lesproveedores as $p){
      $proveedores[$p->id]=$p->nombre;
    }

    $empleados=App\Detalleplanilla::empleados();
@endphp

<div class="modal fade" tabindex="-1" id="modal_evento" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar evento</h4>
      </div>
      <div class="modal-body">
          <form id="form_evento" action="" class="form-horizontal">
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-4">Nombre del evento (*)</label>
                        <div class="col-md-6">
                            <input type="text" autocomplete="off" required name="evento" class="form-control" placeholder="Nombre del indicador">
                        </div>       
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-4">Observaciones (*)</label>
                        <div class="col-md-6">
                            <textarea type="text" required name="descripcion" class="form-control" placeholder="Digite las observaciones"></textarea>
                        </div>       
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Fecha y hora de inicio (*)</label>
                        <div class="col-md-6">
                            <input type="datetime" required name="inicio" class="form-control datetimepicker" placeholder="Digite el porcentaje que aplica">
                        </div>       
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-4">Fecha y hora de finalización (*)</label>
                      <div class="col-md-6">
                          <input type="datetime" required  name="fin" class="form-control datetimepicker" placeholder="Digite el porcentaje que aplica">
                      </div>       
                  </div>
                  </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <center>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_evento" class="btn btn-primary">Registrar</button></center>
      </div>
    </div>
  </div>
</div>

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
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_subir_base" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Subir bases de licitación</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['action'=>'ProyectoController@subirbase', 'class' => '','id' => 'form_subirbase','enctype'=>'multipart/form-data']) }}
            <input type="hidden" name="proyecto_id" value="{{$proyecto->id}}">
            
            <label for="file-upload4" class="subir">
              <i class="glyphicon glyphicon-cloud"></i> Subir archivo
          </label>
          <input id="file-upload4" onchange='cambiar4()' name="archivo" type="file" style='display: none;'/>
          <div id="info6"></div>
              <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_subir_oferta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Subir oferta</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['action'=>'ProyectoController@subiroferta', 'class' => '','id' => 'form_subiroferta','enctype'=>'multipart/form-data']) }}
            <input type="hidden" name="proyecto_id" value="{{$proyecto->id}}">
            <div class="form-group">
              <label for="" class="control-label">Proveedor</label>
              <div>
                {!!Form::select('proveedor_id',
                    $proveedores
                    ,null, ['class'=>'chosen-select-width','placeholder'=>'Seleccione un proveedor'])!!}
              </div>
            </div>
            
            <label for="file-upload3" class="subir">
              <i class="glyphicon glyphicon-cloud"></i> Subir archivo
          </label>
          <input id="file-upload3" onchange='cambiar3()' name="archivo" type="file" style='display: none;'/>
          <div id="info5"></div>
              <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
                <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_ver_coti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="titulo_ver_coti"></h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Marca</th>
                  <th>Unidad de medida</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                </tr>
              </thead>
              <tbody id="aqui_poner_coti">
                
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></center>
          </div>
        </div>
        </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_subir_acta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Subir acta de cierre</h4>
            </div>
            <div class="modal-body">
              {{ Form::open(['action'=>'ProyectoController@subircontrato', 'class' => '','id' => 'form_subiracta','enctype'=>'multipart/form-data']) }}
                  <input type="hidden" name="proyecto_id" value="{{$proyecto->id}}">
                  <div class="form-group">
                    <label for="" class="control-label">Descripción</label>
                    <div>
                      <input type="text" class="form-control" name="descripcion" autocomplete="off" placeholder="Nombre del contrato">
                    </div>
                  </div>
                  <label for="file-upload2" class="subir">
                    <i class="glyphicon glyphicon-cloud"></i> Subir archivo
                </label>
                <input id="file-upload2" onchange='cambiar2()' name="archivo" type="file" style='display: none;'/>
                <div id="info4"></div>
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

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_empleado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Registrar empleado</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['class' => '','id' => 'form_guardar_empleado']) }}
            <input type="hidden" name="proyecto_id" value="{{$proyecto->id}}">
            <input type="hidden" name="salario" value="0">
            <input type="hidden" name="numero_acuerdo" value="null">
            <input type="hidden" name="tipo_pago" value="2">
            <input type="hidden" name="fecha_inicio" value="{{ date("Y-m-01")}}">
            <input type="hidden" name="pago" value="2">
            <div class="form-group">
              <label for="name" class="control-label">Empleado</label>
              <div class="">
                {!!Form::select('empleado_id',
                    $empleados
                    ,null, ['class'=>'chosen-select-width','placeholder'=>'Seleccione un empleado','id'=>'select_empleado'])!!}
              </div>
          </div>

            <div class="form-group">
              <label for="name" class="control-label">Cargo</label>
              <div class="">
                {!!Form::select('cargoproyecto_id',
                    $cargos
                    ,null, ['class'=>'chosen-select-width','placeholder'=>'Seleccione un cargo','required'])!!}
              </div>
          </div>

          <center>
              <button class="btn btn-primary" id="guardar_empleado">Guardar</button>
              <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </center>
        {{Form::close()}}
      </div>
      <!--div class="modal-footer">
        <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="agregar_orden" class="btn btn-success">Agregar</button></center>
      </div-->
    </div>
    </div>
</div>