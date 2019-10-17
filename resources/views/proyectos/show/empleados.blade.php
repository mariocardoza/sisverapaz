@php
$cargos=App\Cargo::cargos();
     $empleados = DB::table('empleados as e')
                  ->select('e.*')
                    ->whereNotExists(function ($query) {
                         $query->from('detalleplanillas')
                            ->whereRaw('detalleplanillas.empleado_id = e.id');
                        })->get();
    $a_empleados=[];
    foreach ($empleados as $e) {
      //if(!$e->detalleplanilla && $e->contrato->count()<1){
          $a_empleados[$e->id]=$e->nombre;
     // }
    }
@endphp
<form id="form_planilla" class="form-horizontal">
        <div class="form-group{{ $errors->has('empleado_id') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Empleado</label>
            
            
                <div class="col-md-6">
                  
                    {!!Form::select('empleado_id',
                      $a_empleados
                      ,null, ['class'=>'chosen-select-width'])!!}
                 
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('salario') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Salario</label>
                <div class="col-md-6">
                  {!!Form::number('salario',null,['class'=>'form-control'])!!}
                  {!!Form::hidden('tipo_pago',2,['class'=>'form-control'])!!}
                  {!!Form::hidden('proyecto_id',$proyecto->id,['class'=>'form-control'])!!}
                </div>
            </div>
            
            <div class="form-group{{ $errors->has('pago') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Tiempo de pago</label>
                <div class="col-md-6">
                  {!!Form::select('pago',
                      ['1'=>'Mensual','2'=>'Quincenal']
                      ,null, ['class'=>'chosen-select-width'])!!}
                </div>
            </div>
            <div class="form-group">
              <label for="" class="col-md-4 control-label">N° de acuerdo</label>
              <div class="col-md-6">
                {!! Form::text('numero_acuerdo',null,['class'=>'form-control']) !!}
              </div>
            </div>
            <div class="form-group{{ $errors->has('fecha_inicio') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Fecha de inicio de labores</label>
              <div class="col-md-6">
                {!!Form::date('fecha_inicio',null,['class'=>'form-control'])!!}
              </div>
            </div>

    <center>
        <button class="btn btn-primary" id="btn_guardarcontrato" type="button">Guardar</button>
        <button class="btn btn-danger" id="btn_cancelarcontrato" type="button">Cancelar</button>
    </center>
</form>