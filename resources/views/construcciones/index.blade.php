@extends('layouts.app')

@section('migasdepan')
<h1>
        Construcciones
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/construcciones') }}"><i class="fa fa-dashboard"></i> Construcciones</a></li>
        <li class="active">Listado de construcciones</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <a href="{{ url('/construcciones/create') }}" id="nuevo" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Contribuyente</th>
                  <th>Inmueble</th>
                  <th>Presupuesto</th>
                  <th>Impuesto</th>
                  <th>% Fiestas </th>
                  <th>Estado</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($construcciones as $index=> $construccion)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $construccion->contribuyente->nombre }}</td>
                    <td>{{ $construccion->inmueble->numero_escritura }}</td>
                    <td>{{ $construccion->presupuesto }}</td>
                    <td>${{ number_format($construccion->impuesto,2) }}</td>
                    <td>${{ number_format($construccion->fiestas,2) }}</td>
                      @if($construccion->estado==1)
                      <td>
                      <label for="" class="col-md-12 label-primary">Pendiente</label>
                      </td>
                      @elseif($construccion->estado==2)
                      <td>
                      <label for="" class="col-md-12 label-danger">Anulada</label>
                      </td>
                      @elseif($construccion->estado==3)
                      <td>
                      <label for="" class="col-md-12 label-success">Pagada y pendiente de recibo</label>
                      </td>
                      @else
                      <td>
                      <label for="" class="col-md-12 label-success">Pagado</label>
                    </td>
                      @endif
                    
                    <td>
                      {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('construcciones/'.$construccion->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                      <a href="{{ url('construcciones/'.$construccion->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                      <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$construccion->id.",'construcciones')" }}><span class="glyphicon glyphicon-trash"></span></button>
                      {{ Form::close()}}
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
<div class="modal fade" tabindex="-1" id="modal_construccion" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar una construcción</h4>
      </div>
      <div class="modal-body">
          <form id="form_construccion" class="">
              <div class="row">
                  <div class="col-md-12">
                    @include('construcciones.formulario')
                  </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Registrar</button></center>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_contribuyente" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar una construcción</h4>
      </div>
      <div class="modal-body">
          <form id="form_contribuyente" class="">
              <div class="row">
                  <div class="col-md-12">
                    @include('contribuyentes.formulario')
                  </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" id="cerrar_contri">Cerrar</button>
        <button type="submit" class="btn btn-success">Registrar</button></center>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  $(document).ready(function(e){

    //abrir nuevo modal
    $(document).on("click","#nuevo",function(e){
      e.preventDefault();
      $("#modal_construccion").modal("show");
    });

    //change a contribuyente
    $(document).on("change","#elcontribuyente",function(e){
      e.preventDefault();
      var id=$(this).val();
      $.ajax({
        url:'construcciones/inmuebles/'+id,
        type:'get',
        dataType:'json',
        success:function(json){
          if(json[0]==1){
            $("#elinmueble").empty();
            $("#elinmueble").html(json[2]);
            $("#elinmueble").trigger("chosen:updated");
          }
        },
        error: function(error){
          toastr.error("Ocurrio un error, intente de nuevo");
        }
      })
    });

    //submit de form_construccion
    $(document).on("submit","#form_construccion",function(e){
      e.preventDefault();
      var datos=$("#form_construccion").serialize();
      $.ajax({
        url:'construcciones',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Registrado con éxito");
            location.reload();
          }
          else{
            if(json[0]==2){
            console.log(json);
            toastr.info(json[2]);
            }else{
              toastr.error("Ocurrió un error");
            }
          }
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(i,v){
            toastr.error(v);
          });
          swal.closeModal();
        }
      });
    });

    //Modal para nuevo contribuynte
    $(document).on("click","#nuevo_contri",function(e){
      e.preventDefault();
      $("#modal_contribuyente").modal("show");
      $("#modal_construccion").modal("hide");
    });

    //cerrar modal contribuyente
    $(document).on("click","#cerrar_contri",function(e){
      e.preventDefault();
      $("#modal_contribuyente").modal("hide");
      $("#modal_construccion").modal("show");
    });

    //submit de form_contribuyente
    $(document).on("submit","#form_contribuyente",function(e){
      e.preventDefault();
      var datos=$("#form_contribuyente").serialize();
      $.ajax({
        url:'contribuyentes',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Contribuyente registros con éxito");
            $("#elcontribuyente").append('<option selected value="'+json[2].id+'">'+json[2].nombre+'</option>');
            $("#elcontribuyente").trigger("chosen:updated");
            $("#form_contribuyente").trigger("reset");
            $("#modal_contribuyente").modal("hide");
            $("#modal_construccion").modal("show");
          }
          
          else{
            toastr.error('Ocurrió un error');
          }
          
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(i,v){
            toastr.error(v);
          });
          swal.closeModal();
        }
      });
    });
  });
</script>
@endsection