@extends('layouts.app')

@section('migasdepan')
<h1>
        Requisiciones
        <small>Control de requisiciones</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de requisiciones</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
              <div class="row">
                <div class="col-md-10">
                  <div class="btn-group">
                    <a href="{{ url('/requisiciones/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                    <a href="javascript:void(0)" data-tipo="1" class="btn btn-primary elver">Activos</a>
                    <a href="javascript:void(0)" data-tipo="2" class="btn btn-primary elver">Rechazados</a>
                    <a href="javascript:void(0)" data-tipo="7" class="btn btn-primary elver">Finalizados</a>
                  </div>
                </div>
                <div class="col-md-2">
                  <select name="" id="select_anio" class="chosen-select pull-right">
                    <option selected value="0">Seleccione un año</option>
                    @foreach ($anios as $anio)
                        <option value="{{$anio->anio}}">{{$anio->anio}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              

              
          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" id="aqui_tabla">
              <table class="table table-striped table-bordered" id="latabla">
                <thead>
                  <th width="3%">N°</th>
                  <th width="10%">Código</th>
                  <th>Actividad</th>
                  <th>Unidad administrativa</th>
                  <th>Fuente de financiamiento</th>
                  <th>Responsable</th>
                  <th>Observaciones</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>
@endsection
@section('scripts')
<script> 
  $(document).ready(function(e){
    cargar_requisiciones(tipo=1);

    $(document).on("click",".elver",function(e){
    var tipo=$(this).attr("data-tipo");
    cargar_requisiciones(tipo);
    });

    $(document).on("change","#select_anio",function(e){
      var anio=$(this).val();
      if(anio!=''){
        cargar_poranio(anio);
      }
      
    });
  });


  function cargar_poranio(anio){
    modal_cargando();
    $.ajax({
      url:'requisiciones/poranio/'+anio,
      type:'get',
      data:{},
      dataType:'json',
      success: function(json){
        if(json[0]==1){
          $("#aqui_tabla").empty();
          $("#aqui_tabla").html(json[1]);
          
          swal.closeModal();
          
        }
        else{
          $("#aqui_tabla").empty();
          $("#aqui_tabla").html(json[1]);
          swal.closeModal();
        }

        inicializar_tabla("latabla");
      }
    });
  }

  function cargar_requisiciones(tipo){
    modal_cargando();
    $.ajax({
      url:'requisiciones/portipo/'+tipo,
      type:'get',
      data:{},
      dataType:'json',
      success: function(json){
        if(json[0]==1){
          $("#aqui_tabla").empty();
          $("#aqui_tabla").html(json[1]);
          
          swal.closeModal();
          
        }
        else{
          swal.closeModal();
        }

        inicializar_tabla("latabla");
      }
    });
  }
</script>
@endsection
