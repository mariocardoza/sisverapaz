@extends('layouts.app') @section('content')
<div class="container">
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
                id="nombre" required
                placeholder="Nombre del cementerio"
              />
            </div>
            <div class="form-group col-sm-4">
              <label for="cantidad">Cantidad</label>
              <input
                type="number"
                class="form-control"
                id="cantidad" min='100'
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
<script type="text/javascript">
  window.onload = function () {
    var pointers = [];
    google.maps.event.addListener(drawingManager, "overlaycomplete", function(polygon) {      
      google.maps.event.addListener(polygon.overlay.getPath(), "insert_at", function() {
        pointers = (polygon.overlay.getPath().getArray());
      });
      google.maps.event.addListener(polygon.overlay.getPath(), "set_at", function() {
        pointers = (polygon.overlay.getPath().getArray());
      });
    });

    document.getElementById('formulario').onsubmit = function(e) {
      e.preventDefault();
      console.log(pointers);
    }
  }
</script>
@endsection