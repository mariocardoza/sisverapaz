<div class="modal fade" tabindex="-1" id="modal_servicio" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Registrar servicio</h4>
        </div>
        <div class="modal-body">
            <form id="form_servicio" action="" class="">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label class="control-label">Proveedor del servicio</label>
                          <div class="">
                              {{ Form::text('nombre', null,['placeholder'=>'Ej. Delsur','class' => 'form-control','autocomplete'=>'off','required']) }}
                          </div>       
                      </div>
                      <div class="form-group">
                          <label class="control-label">Fecha de contratación</label>
                          <div class="">
                              {{ Form::date('fecha_contrato', null,['class' => 'form-control','autocomplete'=>'off','required']) }}
                          </div>       
                      </div>
                   
                    </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" id="registrar_servicio" class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_eservicio" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Editar servicio</h4>
      </div>
      <div class="modal-body">
          <form id="form_eservicio" action="" class="">
              <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Nombre del servicio</label>
                        <div class="">
                            {{ Form::text('nombre', null,['placeholder'=>'Ej. Delsur','class' => 'form-control nom','autocomplete'=>'off','required']) }}
                        </div>       
                    </div>
                    <div class="form-group">
                        <label class="control-label">Fecha de contratación</label>
                        <div class="">
                            {{ Form::text('fecha_contrato', null,['class' => 'form-control fechita fech','autocomplete'=>'off','required']) }}
                        </div>       
                    </div>
                 
                  </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="editar_servicio" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>
  @php
      $serv=App\Servicio::where('estado',1)->get();
      $cuent=App\Cuenta::where('estado',1)->whereYear('created_at',date("Y"))->get();
      $servicios=$cuentas=[];
      foreach($serv as $s){
        $servicios[$s->id]=$s->nombre;
      }
      foreach ($cuent as $c) {
        $cuentas[$c->id]=$c->nombre;
      }
      $meses=[
            [
                'id'=>'1',
                'nombre'=>'Enero'
            ],
            [
                'id'=>'2',
                'nombre'=>'Febrero'
            ],
            [
                'id'=>'3',
                'nombre'=>'Marzo'
            ],
            [
                'id'=>'4',
                'nombre'=>'Abril'
            ],
            [
                'id'=>'5',
                'nombre'=>'Mayo'
            ],
            [
                'id'=>'6',
                'nombre'=>'Junio'
            ],
            [
                'id'=>'7',
                'nombre'=>'Julio'
            ],
            [
                'id'=>'8',
                'nombre'=>'Agosto'
            ],
            [
                'id'=>'9',
                'nombre'=>'Septiembre'
            ],
            [
                'id'=>'10',
                'nombre'=>'Octubre'
            ],
            [
                'id'=>'11',
                'nombre'=>'Noviembre'
            ],
            [
                'id'=>'12',
                'nombre'=>'Diciembre'
            ],
        ];
  @endphp
  <div class="modal fade" tabindex="-1" id="modal_pagarservicio" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Registrar pago de servicio</h4>
        </div>
        <div class="modal-body">
            <form id="form_pagoservicio" action="" class="">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Servicio</label>
                      <div class="">
                         {!! Form::select('servicio_id',$servicios,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione un servicios a cancelar']) !!}
                      </div>       
                    </div>

                    <div class="form-group">
                      <label for="" class="control-label">Monto</label>
                      <div>
                        <input type="number" class="form-control" name="monto">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="" class="control-label">Mes</label>
                      <div>
                        <select name="mes" class="chosen-select-width">
                            @for ($i=0;$i<count($meses);$i++)
                            @if($meses[$i]['id']==date("m"))
                              <option selected value="{{$meses[$i]['nombre']}}">{{$meses[$i]['nombre']}}</option>
                            @else
                            <option value="{{$meses[$i]['nombre']}}">{{$meses[$i]['nombre']}}</option>
                            @endif
                        @endfor
                        </select>
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Cuenta</label>
                      <div class="">
                          {!! Form::select('cuenta_id',$cuentas,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione una cuenta']) !!}
                      </div>       
                    </div>

                    <div class="form-group">
                      <label for="" class="control-label">Fecha de pago</label>
                      <div>
                        <input type="text" name="fecha_pago" class="form-control fechapago">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="" class="control-label">Año</label>
                      <div>
                        <input type="text" name="anio" value="{{date("Y")}}" class="form-control">
                      </div>
                    </div>
                  </div>
              </div>
            </form>
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" id="registrar_pagoservicio" class="btn btn-success">Registrar</button></center>
        </div>
      </div>
    </div>
  </div>