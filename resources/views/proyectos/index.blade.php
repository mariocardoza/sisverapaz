@extends('layouts.app')

@section('migasdepan')
<h1>
        Proyectos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de Proyectos</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p></p>
              <div class="row">
                <div class="col-md-10">
                  <div class="btn-group">
                    <a id="btn_nuevo" href="{{ url('/proyectos/create') }}" class="btn btn-success">Registrar</a>
                    <a href="javascript:void(0)" class="btn btn-primary elver" data-tipo="1">Actuales</a>
                    <a href="javascript:void(0)" class="btn btn-primary elver" data-tipo="2">Rechazados</a>
                    <a href="javascript:void(0)" class="btn btn-primary elver" data-tipo="9">Finalizados</a>
                    <a href="{{url('proyectos/mapas')}}" class="btn btn-info">Ver mapa</a>
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
            <div class="box-body" id="aqui_tabla">
              
              
            </div>
          </div>
        </div>
</div>

@endsection
@section("scripts")
<script> 
  $(document).ready(function(e){
    cargar_proyectos(tipo=1);

    $(document).on("click",".elver",function(e){
      e.preventDefault();
      var tipo=$(this).attr("data-tipo");
      cargar_proyectos(tipo);
    });

    $(document).on("change","#select_anio",function(e){
      var anio=$(this).val();
      if(anio!=''){
        cargar_poranio(anio);
      }
      
    });

    //cargar el registrar proyecto en un modal
    $(document).on("click","#btn_nuevo",function(e){
      //e.preventDefault();
     // $("#modal_proyecto").modal("show");
    });
  });


  function cargar_poranio(anio){
    modal_cargando();
    $.ajax({
      url:'proyectos/poranio/'+anio,
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

  function cargar_proyectos(tipo){
    modal_cargando();
    $.ajax({
      url:'proyectos/portipo/'+tipo,
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