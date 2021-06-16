@extends('layouts.app')

@section('migasdepan')
<h1>
    Partidas de Nacimiento
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">Nuevo</li>
  </ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header">
        <p></p>
        <div class="box-title">
            <p></p>
            <a href="javascript:void(0)" class="btn btn-success new_partida pull-right"><i class="fa fa-plus-circle"></i></a>
            <div class="btn-group">
                <a href="{{url('ingresos?n=0')}}" class="btn btn-primary">Cobros Inmuebles</a>
                <a href="{{url('ingresos?n=1')}}" class="btn btn-primary">Cobros Negocios</a>
                <a href="{{ url('partidas') }}" class="btn btn-primary">Partidas <span class="label label-danger">{{\App\Partida::whereEstado(1)->count()}}</span></a>
                <a href="{{url('construcciones/recibos')}}" class="btn btn-primary">Construcciones <span class="label label-danger">{{\App\Construccion::whereEstado(3)->count()}}</span></a>
                <a href="{{url('perpetuidad/recibos')}}" class="btn btn-primary">Titulos a Perpetuidad <span class="label label-danger">{{\App\Perpetuidad::whereEstado(1)->count()}}</span></a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table" id="example2">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Contribuyente</th>
                            <th>Monto </th>
                            <th>Fiestas</th>
                            <th>Total </th>
                            <th>Creación</th>
                            <th></th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partidas as $index =>$partida)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$partida->contribuyente}}</td>
                                <td>${{number_format($partida->monto,2)}}</td>
                                <td>${{number_format($partida->fiestas*$partida->monto,2)}}</td>
                                <td>${{number_format($partida->monto+$partida->fiestas*$partida->monto,2)}}</td>
                                <td>{{$partida->created_at->diffforhumans(null, false, false, 3)}}</td>
                                <td>
                                    @if($partida->estado==1)
                                    <label for="" class="label-primary col-xs-12"><span class="text-center">Pendiente de cobro</span></label>
                                    @elseif($partida->estado==2)
                                    <label for="" class="label-danger col-xs-12"><span class="text-center">Anulada</span></label>
                                    @else 
                                    <label for="" class="label-success col-xs-12"><span class="text-center">Cobrada</span></label>
                                    @endif
                                </td>
                                <td>
                                    @if($partida->estado==1)
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" title="Editar" data-id="{{$partida->id}}" class="btn btn-warning edit"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" title="Confirmar pago" data-id="{{$partida->id}}" class="btn btn-success cobrar"><i class="fa fa-money"></i></a>
                                        <a target="_blank" href="{{url('reportestesoreria/partida/'.$partida->id)}}" title="Imprimir recibo" class="btn btn-primary"><i class="fa fa-print"></i></a>
                                    @elseif($partida->estado==3)
                                    <a target="_blank" href="{{url('reportestesoreria/partida/'.$partida->id)}}" class="btn btn-primary"><i class="fa fa-print"></i></a>
                                    </div>
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
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Registrar nueva orden de partida de nacimiento</h4>
        </div>
        <div class="modal-body">
          <form method="post" id="form_partida">
          <div class="form-group">
            <label for="" class="control-label">Contribuyente</label>
              <div class="">
                <input type="text" list="contri" name="contribuyente" class="form-control">
                <datalist id="contri">
                    @foreach($contribuyentes as $c)
                        <option value="{{$c->nombre}}">
                    @endforeach
                </datalist>
              </div>
          </div>
          <div class="form-group">
              <label for="" class="control-label">
                  Monto
              </label>
              <div>
                   <input type="number" step="any" name="monto" class="form-control">
              </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Agregar</button></center>
          {{Form::close()}}
        </div>
      </div>
      </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Editar Datos Partida de Nacimiento</h4>
        </div>
        <div class="modal-body">
          <form method="post" id="form_epartida">
          <div class="form-group">
            <label for="" class="control-label">Contribuyente</label>
              <div class="">
                <input type="text" list="contri2" name="contribuyente" class="form-control elname">
                <datalist id="contri2">
                    @foreach($contribuyentes as $c)
                        <option value="{{$c->nombre}}">
                    @endforeach
                </datalist>
              </div>
          </div>
          <div class="form-group">
              <label for="" class="control-label">
                  Monto
              </label>
              <div>
                   <input type="number" step="any" name="monto" class="form-control elmonto">
                   <input type="hidden" class="form-control" id="elid">
              </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Agregar</button></center>
          {{Form::close()}}
        </div>
      </div>
      </div>
</div>
@endsection
@section('scripts')
<script>
    $(function(){
        $(document).on("click",".new_partida",function(e){
            e.preventDefault();
            $("#modal_nuevo").modal("show");
        });

        /* editar partida */
        $(document).on("click",".edit",function(e){
            e.preventDefault();
            let id=$(this).attr("data-id");
            $.ajax({
                url:'/partidas/'+id+'/edit',
                type:'get',
                dataType:'json',
                success:function(json){
                    if(json[0]==1){
                        $(".elname").val(json[2].contribuyente);
                        $(".elmonto").val(json[2].monto);
                        $("#elid").val(json[2].id);
                        $("#modal_edit").modal("show");
                    }else{
                        toastr.error("Ocurrió un error");
                    }
                },
                error: function(error){
                    toastr.error("Ocurrió un error");
                }
            })
        });

        /* cobrar la partida */
        $(document).on("click",".cobrar",function(e){
            e.preventDefault();
            let id=$(this).attr("data-id");
            swal({
                title: '',
                text: "¿Desea registrar este pago?",
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
                        url:'/partidas/pago',
                        type:'post',
                        dataType:'json',
                        data:{id},
                        success: function(json){
                            if(json[0]==1){
                                toastr.success("Pago recibido");
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
                        swal(
                            'Revise el recibo por favor',
                            '',
                            'info'
                        );
                    }
            });
        });

        $(document).on("submit","#form_partida",function(e){
            e.preventDefault();
            var datos=$("#form_partida").serialize();
            modal_cargando();
            $.ajax({
                url:'partidas',
                type:'post',
                dataType:'json',
                data:datos,
                success: function(json){
                    if(json[0]==1){
                        toastr.success('Partida registrada con éxito');
                        location.reload();
                    }else{
                        toastr.error("Ocurrió un error");
                        swal.closeModal();
                    }
                }, error: function(error){
                    $.each(error.responseJSON.errors,function(index,value){
	          		    toastr.error(value);
	          	    });
	          	    swal.closeModal();
                }
            })
        })

        $(document).on("submit","#form_epartida",function(e){
            e.preventDefault();
            var datos=$("#form_epartida").serialize();
            let id=$("#elid").val();
            modal_cargando();
            $.ajax({
                url:'partidas/'+id,
                type:'put',
                dataType:'json',
                data:datos,
                success: function(json){
                    if(json[0]==1){
                        toastr.success('Partida modificada con éxito');
                        location.reload();
                    }else{
                        toastr.error("Ocurrió un error");
                        swal.closeModal();
                    }
                }, error: function(error){
                    $.each(error.responseJSON.errors,function(index,value){
	          		    toastr.error(value);
	          	    });
	          	    swal.closeModal();
                }
            })
        })
    });
</script>
@endsection