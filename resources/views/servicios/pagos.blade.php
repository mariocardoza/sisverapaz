@extends('layouts.app')

@section('migasdepan')
<h1>
  Pagos
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
  <li class="active">Listado de pagos realizados</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-tittle"></h3>
                <div class="btn-group">
                    <a href="javascript:void(0)" id="modal_pagar" class="btn btn-success">Realizar nuevo pago</a>
                    <a href="{{ url('servicios?estado=1') }}" class="btn btn-primary">Cancelados</a>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-stripped">
                            <thead>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Monto del pago</th>
                                <th>Cuenta</th>
                                <th>Mes</th>
                                <th>Año</th>
                                <th>Fecha de pago</th>
                            </thead>
                            <tbody>
                                @foreach ($pagados as $i =>$p)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td>{{$p->servicio->nombre}}</td>
                                        <td>${{number_format($p->monto,2)}}</td>
                                        <td>{{$p->cuenta->nombre}}</td>
                                        <td>{{$p->mes}}</td>
                                        <td>{{$p->anio}}</td>
                                        <td>{{$p->fecha_pago->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('servicios.modales')
@endsection

@section('scripts')
<script>
$(document).ready(function(e){
    
    //abrir modal para registrar el pago
    $(document).on("click","#modal_pagar",function(e){
        e.preventDefault();
        $("#modal_pagarservicio").modal("show");
    });

    //registrar el pago del servicio
    $(document).on("click","#registrar_pagoservicio",function(e){
        e.preventDefault();
        var datos=$("#form_pagoservicio").serialize();
        modal_cargando();
        $.ajax({
            url:'pagar',
            type:'post',
            data:datos,
            success: function(json){
                if(json[0]==1){
                    swal.closeModal();
                    toastr.success("Pago registrado con éxito");
                    location.reload();
                }else{
                    toastr.error("Ocurrió un error");
                    swal.closeModal();
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