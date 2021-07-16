@extends('layouts.app') 
@section('migasdepan')
<h1>
    Cementerio
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{ url('/cementerios') }}"><i class="fa fa-home"></i> Cementerios</a></li>
        <li class="active">Ver cementerio</li>
      </ol>
@endsection
@section('content')
<div style="width: 100%;">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
          <br>
          @if($cementerio->estado==2)
            <h4>Cementerio desabilitado para nuevos entierros</h4><br>
            <h4>Motivo: {{ $cementerio->motivo_baja }} Fecha: {{ $cementerio->fecha_baja->format('d/m/Y')}}</h4><br>
          @endif
        </div>
        <form action="#" id="formulario" name="formulario">
          <div class="box-body">
            @if($cementerio->estado==1)         
              <button type="button" title="Dar de baja" class="btn btn-danger baja" data-id="{{$cementerio->id}}">
                  <i class="fa fa-thumbs-o-down"></i>
              </button>
            @else 
            <button type="button" title="dar de alta" class="btn btn-success restaurar" data-id="{{$cementerio->id}}">
                <i class="fa fa-thumbs-o-up"></i>
            </button>
            @endif
            <br><br>
            <div style="height: 400px;" class="form-group">
              {!! $map['html'] !!}
            </div>
            <div class="form-group col-sm-7">
              <label for="nombre">Nombre del cementerio: </label>
              @if ($isDrawing)
                <input
                  type="text"
                  class="form-control"
                  id="nombre" name="nombre"
                  placeholder="Nombre del cementerio"
                />
              @else
                <h2>{{ $cementerio->nombre }}</h2> 
              @endif
            </div>
            <div class="form-group col-sm-4">
              <label for="cantidad">Cantidad de puestos de perpetuidad</label>
              @if ($isDrawing)
                <input
                  type="number"
                  class="form-control"
                  id="cantidad" min='100' name="cantidad"
                  placeholder="Cantidad Maxima de puestos de perpetuidad"
                />
              @else
                <h2>{{ $cementerio->maximo }}</h2>                  
              @endif
            </div>
            <div class="form-group col-sm-1">
              @if ($isDrawing)
                <button
                  type="submit"
                  style="position: absolute; top: 20px;"
                  class="btn btn-primary">
                  Guardar
                </button>                  
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{!! $map['js'] !!} 
@endsection 
@section('scripts') 
<style>
.swal2-icon::before {
  font-size: 1.75em !important;
}
.swal2-icon {
    width: 100px !important;
    height: 100px !important;
}
.swal2-popup {
  width: 500px !important;
  padding: 2.5em;
  font-size: 1.1rem;
}
</style>
@if ($isDrawing)
  <script src="{{ asset('js/cementerios.js') }}"></script>    
@endif
<script>
  $(function(){
    //baja a un contribuyente
    $(document).on("click",".baja",function(e){
      var id=$(this).attr("data-id");
      swal({
        title: 'Motivo por el que da de baja',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: 'Dar de baja',
        showLoaderOnConfirm: true,
        preConfirm: (text) => {
          return new Promise((resolve) => {
            setTimeout(() => {
              if (text === '') {
                swal.showValidationError(
                  'El motivo es requerido.'
                )
              }
              resolve()
            }, 2000)
          })
        },
        allowOutsideClick: () => !swal.isLoading()
      }).then((result) => {
        if (result.value) {
          var motivo=result.value;
          $.ajax({
            url:'/cementerios/baja/'+id,
            type:'post',
            dataType:'json',
            data:{motivo},
            success: function(json){
              if(json[0]==1){
                toastr.success("Usuario dado de baja");
                location.reload();
              }else{   
                  toastr.error("Ocurrió un error");
              }
            }, error: function(error){
              toastr.error("Ocurrió un error");
            }
          });
        }
      });
    });

    //restaurar contribuyente
    $(document).on("click",".restaurar",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
          title: 'Contribuyente',
          text: "¿Desea restaurar este cementerio?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '¡Si!',
          cancelButtonText: '¡No!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            modal_cargando();
            $.ajax({
              url:'/cementerios/alta/'+id,
              type:'post',
              dataType:'json',
              success: function(json){
                if(json[0]==1){
                  
                  toastr.success("Contribuyente restaurado");
                  location.reload();
                }else{
                  toastr.error("Ocurrió un error");
                  swal.closeModal();
                }
              }, error: function(error){
                toastr.error("Ocurrió un error");
                swal.closeModal();
              }
            });
            
          } else if (result.dismiss === swal.DismissReason.cancel) {
          }
        });
    });
  });
</script>
@endsection