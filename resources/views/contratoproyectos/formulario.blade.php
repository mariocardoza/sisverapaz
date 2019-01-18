<div class="form-group{{ $errors->has('proyecto') ? ' has-error' : '' }}">
    <label for="" class="col-md-4 control-label">Proyecto</label>
    <div class="col-md-6">
        <select name="proyecto" id="proyecto" class="form-control">
            <option value="">Seleccione un proyecto</option>
            @foreach($proyectos as $proyecto)
            <option value="{{$proyecto->id}}">{{$proyecto->nombre}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#form_proyecto"><span class="glyphicon glyphicon-plus"></span></button>
    </div>
</div>


<div class="form-group{{ $errors->has('motivo_contratacion') ? ' has-error' : '' }}">
    <label for="motivo_contratacion" class="col-md-4 control-label">Motivo de contratación</label>
    <div class="col-md-6">
        {!!Form::text('motivo_contratacion',null,['class'=>'form-control','id'=>'motivo_contratacion','autofocus'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('inicio_contrato') ? ' has-error' : '' }}">
    <label for="inicio_contrato" class="col-md-4 control-label">Fecha de inicio</label>

    <div class="col-md-6">
        {{ Form::text('inicio_contrato', null,['class' => 'form-control','id'=>'fecha_inicio']) }}
    </div>
</div>

<div class="form-group{{ $errors->has('fin_contrato') ? ' has-error' : '' }}">
    <label for="fin_contrato" class="col-md-4 control-label">Fecha finalización</label>
    <div class="col-md-6">
        {{Form::text('fin_contrato', null,['class' => 'form-control','id'=>'fecha_fin'])}}
    </div>
</div>

<div class="form-group{{ $errors->has('hora_entrada') ? ' has-error' : '' }}">
    <label for="" class="col-md-4 control-label">Hora de entrada</label>
    <div class="col-md-6">
        {{Form::time('hora_entrada', null, ['class'=>'form-control','id'=>'hora_entrada','autofocus'])}}

    </div>
</div>


<div class="form-group{{ $errors->has('hora_salida') ? ' has-error' : '' }}">
    <label for="" class="col-md-4 control-label">Hora de salida</label>
    <div class="col-md-6">
        {{Form::time('hora_salida', null, ['class'=>'form-control','id'=>'hora_salida','autofocus'])}}

    </div>
</div>
