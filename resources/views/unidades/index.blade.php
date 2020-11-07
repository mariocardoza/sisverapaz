@extends('layouts.app')

@section('migasdepan')
    <h1>
        Unidades Administrativas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Listado</h3>
                    <div class="btn-group pull-right">
                        <a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                        <a href="{{ url('/unidades?estado=1') }}" class="btn btn-primary">Activos</a>
                        <a href="{{ url('/unidades?estado=2')}}" class="btn btn-primary">Papelera</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="example2">
                        <thead>
                        <th>N°</th>
                        <th>Nombre de la unidad</th>
                        <th>Acciones</th>
                        </thead>
                        <tbody>
                        @foreach($unidades as $key => $unidad)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $unidad->nombre_unidad }}</td>
                                <td>
                                    @if($unidad->estado == 1)
                                    {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                    <a href="javascript:(0)" id="edit" data-id="{{$unidad->id}}" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></a>
                                    <button class="btn btn-danger btn-sm" type="button" onclick={{ "baja(".$unidad->id.",'unidades')" }}><span class="glyphicon glyphicon-trash"></span></button>
                                    {{ Form::close()}}
                                    @else
                                    {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                                    <button class="btn btn-success" type="button" onclick={{ "alta(".$unidad->id.",'unidades')"}}><span class="fa fa-refresh"></span></button>
                                    {{ Form::close() }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@include("unidades.modal")
@endsection

@section("scripts")
<script type="">
    $(document).ready(function(e){
        $(document).on('click','#btnmodalagregar',function(e){
            e.preventDefault();
            $("#modal_registrar").modal("show");
        });
        /////FUNCION SUBMIT para guardar unidades administrativas
        $(document).on('submit','#form_unidades',function(e){
            e.preventDefault();
            modal_cargando();
            var uni = $("#form_unidades").serialize();
            $.ajax({
                url:"unidades",
                type:"POST",
                dataType:"json",
                data:uni,

                success: function(retorno)
                {
                    if(retorno[0] == 1)
                    {
                        toastr.success('Registro exitoso');
                        window.location.reload();
                    }

                    else{
                        toastr.error('No se pudo registrar');
                        swal.closeModal();
                    }
                },

                error: function(error)
                {
                    console.log(error.responseJSON.errors);
                    $.each(error.responseJSON.errors, function(index,value){
                        toastr.error(value);
                    });
                    swal.closeModal();
                }
            });
        });
        ///////FUNCIÓN EDITAR
        $(document).on("click", "#edit", function(e){
            e.preventDefault();
            var id = $(this).attr("data-id");
            console.log(id);
            $.ajax({
                url:"unidades/"+id+"/edit",
                type:"get",
                data:{},
                success:function(retorno){
                    if(retorno[0] == 1){
                        $("#modal_editar").modal("show");
                        $("#e_unidad").val(retorno[2].nombre_unidad);
                        $("#elid").val(retorno[2].id);
                    }
                    else{
                        toastr.error("error");
                    }
                }
            });
        });//Fin modal editar

        $(document).on("click", "#btneditar", function(e){
            e.preventDefault();
            
            var id = $("#elid").val();
            var nombre_unidad = $("#e_unidad").val();
            modal_cargando();
            $.ajax({
                url:"unidades/"+id,
                type:"put",
                data:{nombre_unidad},
                success:function(retorno){
                    if(retorno[0] == 1)
                    {
                        toastr.success("Exitoso");
                        $("#modal_editar").modal("hide");
                        window.location.reload();
                    }
                    else{
                        swal.closeModal();
                        toastr.error("error");
                    }
                },
                error: function(error)
                {
                    console.log(error.responseJSON.errors);
                    $.each(error.responseJSON.errors, function(index,value){
                        toastr.error(value);
                    });
                    swal.closeModal();
                }
            });
        });///// Fin btneditar

        $(document).on();
    });
</script>
@endsection