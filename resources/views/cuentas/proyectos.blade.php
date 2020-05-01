@extends('layouts.app')

@section('migasdepan')
<h1>
  Cuentas
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
  <li class="active">Listado de cuentas</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
    <div class="box-header">
      <h3 class="box-tittle">Listado</h3>
      <div class="btn-group">
          <a href="{{ url('/cuentas/proyectos?estado=1') }}" class="btn btn-primary">Activos</a>
          <a href="{{ url('cuentas/proyectos?estado=2') }}" class="btn btn-primary">Papelera</a>
      </div>
      <div class="btn-group pull-right">
      <a href="{{ url('cuentas')}}" class="btn btn-primary">Cuentas </a>
      </div>
    </div>

    <div class="box-body table-responsive">
      <table class="table table-striped table-bordered table-hover" id="example2">
        <thead>
          <th>N°</th>
          <th>Nombre del proyecto</th>
          <th>Número de cuenta</th>
          <th>Monto</th>
          <th>Banco</th>
          <th>Acción</th>
        </thead>
      <tbody>
        @foreach($cuentas as $index=> $cuenta)
        <tr>
          <td>{{$index+1}}</td>
          <td>{{ $cuenta->proyecto->nombre }}</td>
          <td>{{ $cuenta->numero_cuenta }}</td>
          <td>${{ number_format($cuenta->monto_inicial,2) }}</td>
          @if($cuenta->banco_id!='')
          <td>{{ $cuenta->banco->nombre }}</td>
          @else
          <td>Sin asignar banco</td>
          @endif
          <td>
            @if($cuenta->estado == 1)
            {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
            <a href="{{ url('cuentas/movimientos/'.$cuenta->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
            <a href="javascript:void(0)" data-id="{{$cuenta->id}}" id="modaleditar_cuentaproy" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
          <a href="javascript:void(0)" data-id="{{$cuenta->id}}" id="asignar_fondos" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-retweet"></span></a>

            <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$cuenta->id.",'cuentas')" }}><span class="glyphicon glyphicon-trash"></span></button>
            {{ Form::close()}}
            @else
            {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
            <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$cuenta->id.",'cuentas')" }}><span class="glyphicon glyphicon-trash"></span></button>
            {{ Form::close()}}
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
<div id="modal_aqui"></div>
@include('cuentas.modales')
@endsection
@section('scripts')
<script>
  $(document).ready(function(e){
    
    $(document).on("click","#modal_registrar",function(e){
      $("#modal_registrar_cuenta").modal("show");
    });

    $(document).on("click","#modaleditar_cuentaproy",function(e){
        var id=$(this).attr("data-id");
        $("#editar_cuentaproy").attr("data-id",id);
        $("#modal_cuentaproy").modal("show");
    });

    //asignarle fondos a la cuenta del pryecto
    $(document).on("click","#asignar_fondos",function(e){
        var id=$(this).attr("data-id");
        $.ajax({
            url:'modalasignar/'+id+'/'+2,
            type:'get',
            dataType:'json',
            success: function(json){
                if(json[0]==1){
                    $("#modal_aqui").empty();
                    $("#modal_aqui").html(json[2]);
                    $("#modal_agregarfondo_cuentaproy").modal("show");
                    $(".chosen").chosen({
                        'width':'100%'
                    });
                }
            }
        })
    });

     /// imprimir el monto de la cuenta
     $(document).on("change","#select_fondo",function(e){
      var id=$(this).val();
      if(id!=''){
        var monto_cuenta=parseFloat($("#select_fondo option:selected").attr("data-montocuenta")) || 0;
        $("#imp_monto").text("");
        $("#imp_monto").text("$"+monto_cuenta);
      }
    });

    //abonar la cuenta
    $(document).on("click","#abonar_cuenta",function(e){
        e.preventDefault();
        var id=$(this).attr("data-id");
        var elfondo=$("#select_fondo").val();
        var lacuenta=$("#select_fondo option:selected").text();
        var idcuenta=$("#select_fondo option:selected").attr("data-cuenta");
        var acuerdo=$("#n_acuerdo").val();
        var eltope=parseFloat($("#select_fondo option:selected").attr("data-tope")) || 0;
        var eldisponible=parseFloat($("#select_fondo option:selected").attr("data-disponible")) || 0;
        var monto_cuenta=parseFloat($("#select_fondo option:selected").attr("data-montocuenta")) || 0;
        var abono=parseFloat($("#elmonto_abonar").val()) || 0;
        if(elfondo!='' && acuerdo != ''){
            if(abono!=0){
                if(abono <= monto_cuenta){
                    if(abono <= eltope)
                    {
                        if(abono <= eldisponible)
                        {
                            modal_cargando();
                            $.ajax({
                                url:'abonarproyecto',
                                type:'POST',
                                dataType:'json',
                                data:{cuentaproy_id:id,accion:'Se abono de la cuenta '+lacuenta+'',tipo:1,monto:abono,elfondo,idcuenta,acuerdo},
                                success: function(json){
                                    if(json[0]==1){
                                        toastr.success("Abono realizado con éxito");
                                        location.reload();
                                    }else{
                                        toastr.error("Ocurrió un error");
                                        swal.closeModal();
                                    }
                                },error: function(error){
                                    toastr.error("Ocurrió un error");
                                    swal.closeModal(); 
                                }
                            });
                        }else{
                            toastr.error("El monto ingresado sobrepasa lo destinado de la cuenta "+lacuenta+" al proyecto");
                        }
                    }else{
                        toastr.error("El monto ingresado sobrepasa lo destinado de la cuenta "+lacuenta+" al proyecto");
                    }
                }else{
                    toastr.error("El monto supero a lo disponible en la cuenta "+lacuenta);
                }
            }else{
                toastr.error("Digite el monto a abonar");
            }
        }else{
            toastr.error("Seleccione una cuenta y digite el número de acuerdo");
        }
        
        
    });

    $(document).on("click","#editar_cuentaproy",function(e){
        var id=$(this).attr("data-id");
      var datos=$("#form_editarproyecto").serialize();
      modal_cargando();
      $.ajax({
        url:'editarproyectos/'+id,
        type:'PUT',
        dataType:'json',
        data:datos,
        success:function(json){
          if(json[0]==1){
            toastr.success("cuenta registrada exitosamente");
            location.reload();
          }else{
            swal.closeModal();
            toastr.error("Ocurrió un error");
          }
        },error: function(error){
          $.each(error.responseJSON.errors,function(index,value){
	          toastr.error(value);
	        });
          swal.closeModal();
        }
      });
    });
  });
</script>
@endsection