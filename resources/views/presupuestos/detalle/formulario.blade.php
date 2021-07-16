<div class="form-group">
  <label for="" class="col-md-4">Proyecto</label>
    <div class="col-md-6">

        {!!Form::textarea('nombpro',$presupuesto->proyecto->nombre,['class' => 'form-control','readonly','rows' => 3])!!}
        {!! Form::hidden('',$presupuesto->id,['id'=>'presuid']) !!}
        {!! Form::hidden('',$presupuesto->proyecto->monto,['id' => 'monto']) !!}

    </div>
</div>

<div class="form-group">
    <label for="" class="col-md-4">Ítem</label>
    <div class="col-md-6" id="select">
      {{Form::hidden('',$presupuesto->categoria->id,['id' => 'itemid'])}}
      {!!Form::text('',$presupuesto->categoria->item .' '.$presupuesto->categoria->nombre_categoria,['class' => 'form-control','readonly'])!!}
    </div>

</div>
<div class="form-group">
    <label for="" class="col-md-4">Descripción</label>
    <div class="col-md-6">
      <select class="chosen-select-width" id="catalogo">
        <option value="">Seleccione una descripción</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalcatalogo"><span class="glyphicon glyphicon-plus"></span></button>
    </div>
</div>
<div class="form-group">
    <label for="" class="col-md-4">Digite la cantidad que necesita</label>
    <div class="col-md-6">
        <input type="number" id="cantidad" class="form-control">
    </div>
</div>
<div class="form-group">
    <label for="" class="col-md-4">Digite el precio unitario</label>
    <div class="col-md-6">
        <input type="number" id="precio" class="form-control">
    </div>
</div>

<div class="form-group">
    <div class="col-md-6">
      <button type="button" id="agregaratabla" class="btn btn-success">Agregar</button>
    </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalcatalogo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="row">
<div class="panel panel-primary">
<div class="panel-heading">Ingreso de Categoría
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="panel-body">
  <div class="form-group">
    <label for="" class="col-md-4">Categoria</label>
    <div class="col-md-6">
      <input type="hidden" id="categoria_id" value="{{$presupuesto->categoria->id}}">
      <input type="text" readonly value="{{$presupuesto->categoria->item .' '.$presupuesto->categoria->nombre_categoria}}" id="" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="" class="col-md-4">Digite una opción</label>
    <div class="col-md-6">
        <input type="text" id="txtdescripcion" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="" class="col-md-4">Unidad de medida</label>
    <div class="col-md-6">
      <select class="chosen-select-width" id="txtunidad">
        <option value="">Seleccione una unidad de medida</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUnidades"><span class="glyphicon glyphicon-plus"></span></button>
    </div>
  </div>
</div>
<div class="panel-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
<button type="button" id="guardarcatalogo" data-dismiss="modal" class="btn btn-success">Agregar</button>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalUnidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="row">
<div class="panel panel-primary">
<div class="panel-heading">Ingreso de unidad de medida
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="panel-body">
<div class="form-group">
<label for="" class="col-md-4">Digite una unidad de medida</label>
<div class="col-md-6">
    <input type="text" id="txtnombreunidades" class="form-control">
</div>
</div>
</div>
<div class="panel-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
<button type="button" id="guardarunidades" data-dismiss="modal" class="btn btn-success">Agregar</button>
</div>
</div>
</div>
</div>
</div>
