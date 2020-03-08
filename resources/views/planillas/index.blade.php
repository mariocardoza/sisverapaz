@extends('layouts.app')
@section('migasdepan')
  <h1>
    Planillas
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">Control de planillas</li>
  </ol>
@endsection
@php
$tipo_pago= ['1'=>'Planilla mensual','2'=>'Planilla quincenal'];
@endphp
@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"></h3>
          <div class="row">
            <div class="col-md-10">
              <a href="{{ url('/planillas/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Nueva</a>
            </div>
            <div class="col-md-2 pull-right">
              <div class="form-group">
                <label for="" class="control-label">Seleccione el año</label>
                <select name="" id="select_anio" class="chosen-select pull-right">
                  <option  value="0">Seleccione un año</option>
                  @foreach ($anios as $anio)
                      @if($anio->anio==$elanio)
                      <option selected value="{{$anio->anio}}">{{$anio->anio}}</option>
                      @else 
                      <option value="{{$anio->anio}}">{{$anio->anio}}</option>
                      @endif
                  @endforeach
                </select>
                <button class="btn btn-primary" id="btn_anio">Aceptar</button>
              </div>
            </div>
          </div>
        </div>

        <div class="box-body table-responsive">
          <table class="table table-striped table-bordered table-hover" id="example2">
            <thead>
              <th>N°</th>
              <th>Fecha de generación</th>
              <th>Detalle</th>
              <th>Estado</th>
              <th>Acción</th>
            </thead>
            <tbody>
              @foreach($planillas as $key => $planilla)
                <tr>
                  <td>{{$key+1}}</td>
                  @php
                      $dato= explode("-",$planilla->fecha);
                  @endphp
                    <td>{{$dato[2]."/".$dato[1]."/".$dato[0]}}</td>
                    <td>{{$tipo_pago[$planilla->tipo_pago]}}</td>
                    @if($planilla->estado==1)
                    <td>
                      <label for="" class="col-md-12 label-primary">Pendiente</label>
                    </td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ url('planillas/'.$planilla->id)}}" title="Ver planilla" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                        <a href="javascript:void(0)" id="anular_planilla" data-id="{{$planilla->id}}" title="Anular planilla" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                        <a href="javascript:void(0)" id="emitir_boletas" data-id="{{$planilla->id}}" title="Emitir boletas de pago" class="btn btn-info"><span class="fa fa-check"></span></a>
                        <a href="{{ url('reportestesoreria/planillas/'.$planilla->id) }}" title="Imprimir planilla" class="btn btn-success" target="_blank"><span class="fa fa-print"></span></a>
                      </div>
                    </td>
                      @elseif($planilla->estado==2) 
                      <td>
                      <label for="" class="col-md-12 label-danger">Anulada</label>
                      </td>
                      <td>
                        <div class="btn-group">
                          <a href="{{ url('planillas/'.$planilla->id)}}" title="Ver planilla" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{ url('reportestesoreria/planillas/'.$planilla->id) }}" title="Imprimir planilla" class="btn btn-success" target="_blank"><span class="fa fa-print"></span></a>
                        </div>
                      </td>
                      @elseif($planilla->estado==3)
                      <td>
                      <label for="" class="col-md-12 label-info">Boletas emitidas</label>
                      </td>
                      <td>
                        <div class="btn-group">
                          <a href="{{ url('planillas/'.$planilla->id)}}" title="Ver planilla" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{ url('reportestesoreria/planillaaprobada/'.$planilla->id) }}" title="Imprimir planilla" class="btn btn-success" target="_blank"><span class="glyphicon glyphicon-list"></span></a>
                        </div>
                      </td>
                      @else 
                      <td>
                      <label for="" class="col-md-12 label-success">Pago realizado</label>
                      </td>
                      <td>
                        <div class="btn-group">
                          <a href="{{ url('planillas/'.$planilla->id)}}" title="Ver planilla" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{ url('reportestesoreria/planillas/'.$planilla->id) }}" title="Imprimir planilla" class="btn btn-success" target="_blank"><span class="glyphicon glyphicon-list"></span></a>
                        </div>
                      </td>
                      @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(e){
    //select para filtrar por año
    $(document).on("click","#btn_anio",function(e){
      var anio=$("#select_anio").val();
      if(anio > 0){
        location.href="planillas?anio="+anio;
      }
    });


    //boton para anular
    $(document).on("click","#anular_planilla",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
        title: '¿Motivo por el que va anular la planilla?',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: 'Anular',
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
          $.ajax({
            url:'planillas/'+id,
            type:'delete',
            dataType:'json',
            data:{motivo:result.value},
            success: function(json){
              if(json[0]==1){
                toastr.success("Planilla anulada con éxito");
              }else{
                toastr.error("Ocurrioó un error");
              }
            }
          });
        }
      });
    });

    //emitir boletas
    $(document).on("click","#emitir_boletas",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
          title: '¿Emitir las boletas de pago?',
          text: "¿Desea emitir las boletas de pago?",
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
              url:'planillas/'+id,
              type:'put',
              dataType:'json',
              data:{},
              success: function(json){

              }
            });
            
          } else if (result.dismiss === swal.DismissReason.cancel) {
            swal(
              'Cancelado',
              'Seleccione un proveedor',
              'info'
            )
            
          }
        });
    });

  });
</script>
@endsection
