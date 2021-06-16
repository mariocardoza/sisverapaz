@extends('layouts.app')

@section('migasdepan')
  <h1>
    Pago a Cuenta
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li><a href="{{ url('/planillaproyectos') }}"><i class="fa fa-money"></i> Planilla Proyectos</a></li>
    <li class="active">Pago a Cuenta</li>
  </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <p></p>
            <div class="box-header">
                <p></p>
                <div class="btn-group pull-right">
                    <a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="fa fa-plus-circle"></span></a>
                    <a href="{{ url('/pagocuentas?estado=1') }}" class="btn btn-primary">Activos</a>
                    <a href="{{ url('/pagocuentas?estado=0') }}" class="btn btn-primary">Papelera</a>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-hover" id="example2">
                    <thead>
                        <th>N°</th>
                        <th>Nombre completo</th>
                        <th>NIT</th>
                        <th>DUI</th>
                        <th>Dirección</th>
                        <th>Monto</th>
                        <th>Renta</th>
                        <th>Liquido</th>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $index => $p)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$p->nombre}}</td>
                                <td>{{$p->nit}}</td>
                                <td>{{$p->dui}}</td>
                                <td>{{$p->direccion}}</td>
                                <td>${{number_format($p->pago,2)}}</td>
                                <td>${{number_format($p->renta,2)}}</td>
                                <td>${{number_format($p->liquido,2)}}</td>
                                <td>
                                    @if($estado == 1 || $estado == "")
                                    {{ Form::open(['method' => 'POST', 'id' => 'baja', 'clas' => 'form-horizontal']) }}
                                    <div class="btn-group">
                                        <a href="javascript:(0)" id="edit" data-id="{{$pagocuenta->id}}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                        <button class="btn btn-danger" type="button" onclick={{ "baja(".$pagocuenta->id.",'pagocuentas')"}}><span class="fa fa-thumbs-o-down"></span></button>
                                    </div>
                                    {{ Form::close() }}

                                    @else
                                    {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal']) }}
                                    <button class="btn btn-success" type="button" onclick={{ "alta(".$pagocuenta->id.",'pagocuentas')" }}><span class="fa fa-thumbs-o-up"></span>
                                    </button>
                                    {{ Form::close() }}
                                    @endif
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

@include("pagocuentas.modales")
@endsection

@section("scripts")
<script>
    $(document).ready(function(e){
        $(document).on("click", "#btnmodalagregar", function(e){
            $("#modal_registrar").modal("show");
        });

        $(document).on("click", "#btnguardar", function(e){
            e.preventDefault();
            var datos = $("#form_pagocuenta").serialize();
            $.ajax({
                url:"pagocuentas",
                type:"post",
                data:datos,
                success:function(retorno){
                    if(retorno[0] == 1){
                        toastr.success("Registrado con éxito");
                        $("#modal_registrar").modal("hide");
                        window.location.reload();
                    }
                    else{
                        toastr.error("Falló");
                    }
                },
                error:function(error){
                    console.log();
                    $(error.responseJSON.errors).each(function(index,valor){
                        toastr.error(valor,nombre);
                    })
                }
            });
        });

        $(document).on("click", "#edit", function(){
            var id = $(this).attr("data-id");
            $.ajax({
                url:"pagocuentas/"+id+"/edit",
                type:"get",
                data:{},
                success:function(retorno){
                    if(retorno[0] == 1){
                        $("#modal_editar").modal("show");
                        $("#e_nombre").val(retorno[2].nombre);
                        $("#elid").val(retorno[2].id);
                    }
                    else{
                        toastr.error("error");
                    }
                }
            });
        });

        $(document).on("click", "#btneditar", function(e){
            var id = $("#elid").val();
            var nombre = $("#e_nombre").val();

            $.ajax({
                url:"pagocuentas/"+id,
                type:"put",
                data:{nombre},
                success:function(retorno){
                    if(retorno[0] == 1){
                        toastr.success("Exitoso");
                        $("#modal_editar").modal("hide");
                        window.location.reload();
                    }
                    else{
                        toastr.error("error");
                    }
                }
            });
        });//btn editar

        $(document).on()
    });
</script>
@endsection