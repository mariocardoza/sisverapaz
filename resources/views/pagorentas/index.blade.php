@extends('layouts.app')

@section('migasdepan')
  <h1>
    Pago de renta
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li><a href="{{ url('/planillaproyectos') }}"><i class="fa fa-money"></i> Pago de Renta</a></li>
    <li class="active">pago de renta</li>
  </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <table class="table" id="example2">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre completo</th>
                            <th>DUI</th>
                            <th>NIT</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Renta</th>
                            <th>Líquido</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagorentas as $index => $p)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$p->nombre}}</td>
                                <td>{{$p->dui}}</td>
                                <td>{{$p->nit}}</td>
                                <td>{{$p->concepto}}</td>
                                <td>${{number_format($p->total,2)}}</td>
                                <td>${{number_format($p->renta,2)}}</td>
                                <td>${{number_format($p->liquido,2)}}</td>
                                <td>
                                    @if($p->estado == 1)
                                    <button type="button" class="btn btn-info" id="botoncito" data-id="{{$p->id}}">Pagar</button>
                                    
                                    @else
                                    <a href="{{url('reportestesoreria/pagorenta/'.$p->id)}}" class="btn btn-info">Imprimir</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section("scripts")
<script type="">
    $(document).ready(function(e){
        //INICIO FUNCION BOTONCITO
        $(document).on('click','#botoncito',function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            swal({
          title: '¿Está seguro?',
          text: "¿Desea realizar el pago de la impuesto/renta al cliente?",
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
            $.ajax({
                url:"pagorentas",
                type:"POST",
                dataType:"json",
                data:{id},
                success: function(r){
                    if(r[0]==1)
                    {
                        toastr.success("Pago de Impuesto/Renta realizado exitosamente");
                        window.location.reload();
                    }
                    else if(r[0]==2)
                    {
                        toastr.error(r[1]);
                    }

                    else{
                        toastr.error("Ocurrió un error");
                    }
                },
                error: function(nr){

                }
            });
            
          } else if (result.dismiss === swal.DismissReason.cancel) {
            swal(
              'Cancelado',
              'Revise la información',
              'info'
            )
            $('input[name=seleccionarr]').attr('checked',false);
          }
        });
            //alert(id);
            
        });
    });
</script>
@endsection