@extends('layouts.app') @section('content')
<div style="width: 100%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Cementerio</h3>
        </div>
        <form action="#" id="formulario" name="formulario">
          <div class="box-body">
            <div style="height: 400px;" class="form-group">
              {!! $map['html'] !!}
            </div>
            <div class="form-group col-sm-7">
              <label for="nombre">Nombre del cementerio: </label>
              <input
                type="text"
                class="form-control"
                id="nombre" name="nombre"
                placeholder="Nombre del cementerio"
              />
            </div>
            <div class="form-group col-sm-4">
              <label for="cantidad">Cantidad de puestos de perpetuidad</label>
              <input
                type="number"
                class="form-control"
                id="cantidad" min='100' name="cantidad"
                placeholder="Cantidad Maxima de puestos de perpetuidad"
              />
            </div>
            <div class="form-group col-sm-1">
              <button
                type="submit"
                style="position: absolute; top: 20px;"
                class="btn btn-primary">
                Guardar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{!! $map['js'] !!} @endsection @section('scripts') 

<script src="{{ asset('js/cementerios.js') }}"></script>
@endsection