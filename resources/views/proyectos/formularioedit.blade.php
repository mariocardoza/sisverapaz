                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                {!! Form::hidden('id',null,['id' => 'idp']) !!}
                                {!!Form::textarea('nombre',null,['class'=>'form-control','rows' => 2, 'id'=>'nombre','autofocus'])!!}
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
                            <label for="monto" class="col-md-4 control-label">Monto</label>

                            <div class="col-md-4">
                                {!!Form::number('monto',null,['class'=>'form-control','id'=>'monto','readonly','steps' => '0.00'])!!}
                            </div>
                            <button type="button" class="btn btn-primary" name="button" id="verfondos" data-toggle="modal" data-target="#btnverfondos"><span class="glyphicon glyphicon-eye-open"></span></button>
                        </div>

                        <div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }}">
                            <label for="motivo" class="col-md-4 control-label">Justificación</label>

                            <div class="col-md-6">
                                {!!Form::textarea('motivo',null,['class'=>'form-control','id'=>'motivo','autofocus', 'rows'=>3])!!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <label for="direccion" class="col-md-4 control-label">Dirección donde se desarrollará</label>

                            <div class="col-md-6">
                                {!!Form::textarea('direccion',null,['class'=>'form-control','id'=>'direccion','autofocus','rows'=>3])!!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('fecha_inicio') ? ' has-error' : '' }}">
                            <label for="fecha_inicio" class="col-md-4 control-label">Periodo del proyecto</label>

                            <div class="col-md-3">
                                <label for="fecha_inicio" class="control-label">Fecha de inicio</label>
                                {!!Form::text('fecha_inicio',$proyecto->fecha_inicio->format('d-m-Y'),['class'=>'fecha form-control','id'=>'fecha_inicio','autofocus'])!!}
                            </div>
                            <div class="col-md-3">
                              <label for="fecha_fin" class="control-label">Fecha de finalización</label>
                                {!!Form::text('fecha_fin',$proyecto->fecha_fin->format('d-m-Y'),['class'=>'fecha form-control','id'=>'fecha_fin','autofocus'])!!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('beneficiarios') ? ' has-error' : '' }}">
                            <label for="fecha_fin" class="col-md-4 control-label">Beneficiarios</label>

                            <div class="col-md-6">
                                {!!Form::text('beneficiarios',null,['class'=>'form-control','id'=>'beneficiarios','autofocus'])!!}
                            </div>
                        </div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="btnverfondos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Fondos
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    @include('proyectos.fondos.formulario')
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalcategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Ingreso de Categoría
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="" class="col-md-4">Digite la categoría</label>
                        <div class="col-md-6">
                            <input type="text" id="cate" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarcategoria" class="btn btn-success">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>
