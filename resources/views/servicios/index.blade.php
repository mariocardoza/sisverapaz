@extends('layouts.app')

@section('migasdepan')
<h1>
  Servicios
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
  <li class="active">Listado de servicios</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-tittle"></h3>
        <div class="btn-group">
            <a href="javascript:void(0)" id="modal_registrar" class="btn btn-success">Registrar nuevo</a>
            <a href="{{ url('servicios?estado=1') }}" class="btn btn-primary">Actuales</a>
            <a href="{{ url('servicios?estado=2') }}" class="btn btn-primary">Cancelados</a>
        </div>
      </div>

    <div class="box-body table-responsive">
      <table class="table table-striped table-bordered table-hover" id="example2">
        <thead>
          <th>N°</th>
          <th>Nombre del servicio</th>
          <th>Fecha de contratación</th>
          <th>Acción</th>
        </thead>
        <tbody>
            @foreach ($servicios as $i => $s)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$s->nombre}}</td>
                    <td>{{$s->fecha_contrato->format("d/m/Y")}}</td>
                    <td>

                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>

      <div class="pull-right">
        
      </div>
    </div>
  </div>
  </div>
</div>
<div id="modal_aqui"></div>
@include('servicios.modales')
@endsection
@section('scripts')
<script>
$(document).ready(function(e){

    $(document).on("click","#modal_registrar",function(e){
        e.preventDefault();
        $("#modal_servicio").modal("show");
    });

    //registrar servicio
    $(document).on("click","#registrar_servicio",function(e){
        e.preventDefault();
        var datos=$("#form_servicio").serialize();
        modal_cargando();
        $.ajax({
            url:'servicios',
            type:'post',
            data:datos,
            success: function(json){
                if(json[0]==1){
                    toastr.success("Servicio registrado con éxito");
                    location.reload();
                }else{
                    swal.closeModal();
                    toastr.error("A ocurrido un error en la operación");
                }
            },
            error: function(error){
                $.each(error.responseJSON.errors, function( key, value ) {
                    toastr.error(value);
                });
                swal.closeModal(); 
            }
        })
    });
});
</script>
@endsection