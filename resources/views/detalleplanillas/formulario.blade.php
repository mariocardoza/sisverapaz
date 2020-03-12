<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="name" class="control-label">Empleado</label>
  
      @php
        $cargos=App\Cargo::cargos();
        $catcargos=App\CatCargo::catcargos();
        if(!isset($empleado)):
        $empleados=App\Detalleplanilla::empleados();
        endif;
      
        $proys=App\Proyecto::where('anio',date("Y"))->where('estado','!=',12)->get();
        $proyectos=[];
        foreach ($proys as $e) {
            $proyectos[$e->id]=$e->nombre;
          }
        $unids=App\Unidad::where('estado',1)->get();
        $unidades=[];
        foreach ($unids as $u ) {
          $unidades[$u->id]=$u->nombre_unidad;
        }
        @endphp
        <div class="">
          @if (isset($detalle))
            {!!Form::select('empleado_id',
              [$detalle->empleado->id=>$detalle->empleado->nombre]
              ,null, ['class'=>'form-control','readonly'=>'readonly'])!!}
          @else
            {!!Form::select('empleado_id',
              $empleados
              ,null, ['class'=>'form-control'])!!}
          @endif
        </div>
    </div>
  
      <div class="form-group">
          <label for="name" class="control-label">Salario</label>
          <div class="">
            {!!Form::number('salario',null,['class'=>'form-control','placeholder'=>'Ej. 300','autocomplete'=>'off'])!!}
          </div>
      </div>
  
      <div class="form-group">
          <label for="name" class="control-label">Forma de pago</label>
          <div class="">
            {!!Form::select('tipo_pago',
                [''=>'Seleccione la forma de pago','1'=>'Planilla','2'=>'Contrato']
                ,null, ['class'=>'chosen-select-width','id'=>'select_tipo'])!!}
          </div>
      </div>
  
      <div class="form-group">
        <label for="" class="control-label">Categoría de empleados</label>
        <div class="">
          {!!Form::select('',
                $catcargos
                ,null, ['class'=>'chosen-select-width','placeholder'=>'Seleccione una categoría para el cargo','id'=>'select_catcargo'])!!}
        </div>
      </div>
  
      <div class="form-group">
          <label for="name" class="control-label">Cargo</label>
          <div class="">
            <select name="cargo_id" id="select_cargo" class="chosen-select-width">
              <option value="">Seleccione un cargo</option>
            </select>
            
          </div>
      </div>
  
      <div class="form-group">
        <label for="" class="control-label">Unidad administrativa</label>
        <div class="">
            {!!Form::select('unidad_id',
            $unidades
            ,null, ['class'=>'chosen-select-width','placeholder'=>'Seleccione una unidad administrativa','id'=>'select_unidad'])!!}
        </div>
      </div>
  
      <div class="form-group{{ $errors->has('proyecto_id') ? ' has-error' : '' }} elproy" style="display:none;">
          <label for="name" class="control-label">Proyecto</label>
          <div class="">
            <input type="hidden" name="pago" value="1">
            {!!Form::select('proyecto_id',$proyectos
                ,null, ['class'=>'chosen-select-width','id'=>'select_proy','disabled'])!!}
          </div>
      </div>
  
  <!--div class="form-group{{ $errors->has('pago') ? ' has-error' : '' }}">
      <label for="name" class="col-md-4 control-label">Tiempo de pago</label>
      <div class="col-md-6">
        {!!Form::select('pago',
            ['1'=>'Mensual','2'=>'Quincenal']
            ,null, ['class'=>'chosen-select-width'])!!}
      </div>
  </div-->
  
      <div class="form-group">
        <label for="numero_acuerdo" class="control-label">Número del acuerdo</label>
        <div class="">
          {{Form::text('numero_acuerdo',null,['class'=>'form-control','placeholder'=>'Digite el número de acuerdo para el contrato','autocomplete'=>'off'])}}
        </div>
      </div>
  
      <div class="form-group">
        <label for="name" class="control-label">Fecha de inicio de labores</label>
        <div class="">
          @if(isset($empleado->detalleplanilla))
            @if($empleado->detalleplanilla->fecha_inicio!='')
            {!!Form::text('fecha_inicio',$empleado->detalleplanilla->fecha_inicio->format('d-m-Y'),['class'=>'form-control fechita','autocomplete'=>'off'])!!}
            @endif
          @else
          {!!Form::text('fecha_inicio',null,['class'=>'form-control fechita','autocomplete'=>'off'])!!}

          @endif
        </div>
      </div>
  </div>
</div>
