@php
    $lacuentas=\App\Cuenta::where('estado',1)->get();
    $cuentas=[];
    foreach($lacuentas as $item){
      $cuentas[$item->id]=$item->nombre;
    }
@endphp
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_aprobar_requisicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-sm">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Aprobar requisición</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(['class' => '','id' => 'form_aprobarrequi','enctype'=>'multipart/form-data']) }}
              <input type="hidden" name="requisicion_id" value="{{$solicitud->id}}">
              <label for="" class="control-label">Para aprobar la requisición debe seleccionar una fuente de financiamiento</label>
              <div class="form-group">
                <label for="" class="control-label"></label>
                <div>
                  {!! Form::select('cuenta_id',$cuentas,null,['class'=>'chosen-select-width','placeholder'=>'seleccione la fuente e financiamiento','required'=>'']) !!}
                </div>
              </div>
          
          {{Form::close()}}
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="aprobar_requisicion" class="btn btn-success">Aprobar</button></center>
        </div>
      </div>
      </div>
    </div>
