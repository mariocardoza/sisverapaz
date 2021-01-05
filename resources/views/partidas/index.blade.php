@extends('layouts.app')

@section('migasdepan')
<h1>
    Partidas de nacimiento
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
        <div class="box-title">
            <h3>Nuevo registro</h3>
            <a href="javascript:void(0)" class="btn btn-success new_partida"><i class="fa fa-plus"></i> Nueva</a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Contribuyente</th>
                            <th>Monto </th>
                            <th>% fiestas</th>
                            <th>Total </th>
                            <th>Creación</th>
                            <th>Acción</th>
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
                                <td><a href="{{url('partidas/'.$partida->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
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
          <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
    });
</script>
@endsection