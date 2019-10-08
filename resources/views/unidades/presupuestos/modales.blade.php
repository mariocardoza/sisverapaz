@php
    $unidades = App\Unidad::where('estado',1)->get();
@endphp
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_material" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="nom_material">Registrar presupuesto</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['class' => '','id' => 'form_material']) }}
              
            <div class="form-group">
                <label for="" class="control-label">Cantidad</label>
                <div class="">
                    <input type="number" autocomplete="off" min="1" steps="any" required name="cantidad" value="" class="form-control">
                    <input type="hidden" id="id_mat" name="material_id" value="" class="form-control">
                  <input type="hidden" id="elpresuid" name="presupuestounidad_id" value="" class="form-control">

            </div>
            </div>

            <div class="form-group">
                <label for="" class="control-label">Precio unitario</label>
                <div>
                <input type="number" min="1" steps="any" autocomplete="off" required name="precio" value="" class="form-control">
                </div>
            </div>
                      
          {{Form::close()}}
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="registrar_presupuesto" class="btn btn-success">Agregar</button></center>
        </div>
      </div>
      </div>
</div>
    <!-- Modal -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_detalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Necesidad</h4>
          </div>
          <div class="modal-body">
              <form id="form_detalle" class="form-horizontal">
              <table class="table" id="latabla">
                  <thead>
                  <tr>
                      <th>N°</th>
                      <th>Nombre</th>
                      <th>Categoría</th>
                      <th>Unidad de medida</th>
                      <th></th>
                  </tr>
                  </thead>
                  <tbody id="losmateriales">
                  
                  </tbody>
              </table>
              </form>
          </div>
          <!--div class="modal-footer">
              <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" id="agregar_otro" class="btn btn-success">Agregar</button></center>
          </div-->
          </div>
          </div>
    </div>
<!-- Modal -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_presupuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Registrar presupuesto</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['class' => '','id' => 'form_presupuesto']) }}
              
            <div class="form-group">
                <label for="" class="control-label">Unidad administrativa</label>
                <div class="">
                    @if(isset($unidades))
                      <select id="uni_id" name="unidad_admin" class="form-control chosen-select-width ">
                          @foreach($unidades as $unidad)
                            @if($unidad->id==Auth()->user()->unidad_id)
                            <option selected value="{{$unidad->id}}">{{$unidad->nombre_unidad}}</option>
                            @endif
                          @endforeach
                      </select>
                    @else
                      {!!Form::hidden('unidad',$unidad->id)!!}
                    @endif
            </div>

            <div class="form-group">
                <label for="" class="control-label">Año</label>
                <div>
                <input type="text" id="elaniopresu" name="anio" value="{{date('Y')}}" class="form-control">
                </div>
            </div>
                      
          {{Form::close()}}
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="registrar_presupuesto" class="btn btn-success">Agregar</button></center>
        </div>
      </div>
      </div>
</div>



