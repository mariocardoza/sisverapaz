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
              <div class="btn-group pull-right">
                <a href="{{ url('/proyectos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                <a href="{{ url('/proyectos') }}" class="btn btn-primary">Todos</a>
                <a href="{{ url('/proyectos?estado=1') }}" class="btn btn-primary">Priorizados</a>
                <a href="{{ url('/proyectos?estado=2') }}" class="btn btn-primary">Liquidación</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th with="5%">N°</th>
                  <th with="20%">Nombre Proyecto</th>
                  <th with="10%">Monto</th>
                  <th with="25%">Dirección</th>
                  <th with="10%">Inicio</th>
                  <th with="10%">Fin</th>
                  <th with="10%">Estado</th>
                  <th with="10%">Accion</th>
                  <?php $contador=0; ?>
                </thead>
                <tbody>
                  @foreach($proyectos as $proyecto)
                  <tr>
                    <?php $contador++; ?>
                    <td>{{ $contador }}</td>
                    <td>{{ $proyecto->nombre }}</td>
                    <td>${{ number_format($proyecto->monto,2) }}</td>
                    <td>{{ $proyecto->direccion }}</td>
                    <td>{{ $proyecto->fecha_inicio->format('d-m-Y') }}</td>
                    <td>{{ $proyecto->fecha_fin->format('d-m-Y') }}</td>
                    <td>
                      <span class="label-{{estilo_proyecto($proyecto->estado)}}">{{proyecto_estado($proyecto->estado)}}</span>
                    </td>
                    <td>
                      @if( $estado == "" )
                        {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                        <div class="btn-group">
                          <a title="Ver información del proyecto" href="{{ url('proyectos/'.$proyecto->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                          @if( $proyecto->estado == 1 )
                            <a href="{{ url('proyectos/'.$proyecto->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                            <a title="Ver y registar el presupuesto para este proyecto" href="{{ url('presupuestos?proyecto='.$proyecto->id) }}" class="btn btn-success btn-xs"><span class="fa fa-balance-scale"></span></a>
                          @elseif( $proyecto->estado == 2)
                            <a title="Ver y registar el presupuesto para este proyecto" href="{{ url('presupuestos?proyecto='.$proyecto->id) }}" class="btn btn-success btn-xs"><span class="fa fa-balance-scale"></span></a>
                            <a href="{{ url('proyectos/'.$proyecto->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                            <button title="Finalizar el registro de los presupuestos" type="button" onclick="{{ "cambiar(".$proyecto->id.")" }}" class="btn btn-default btn-xs"><span class="fa fa-check"></span></button>
                          @elseif( $proyecto->estado == 3)
                            <a title="Ver y registrar las cotizaciones" href="{{ url('solicitudcotizaciones/create/'.$proyecto->id) }}" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-align-right"></span></a>
                            <a href="{{ url('proyectos/'.$proyecto->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                          @elseif( $proyecto->estado == 4 || $proyecto->estado==5 )
                            <a title="Ver las solicitudes realizadas para este proyecto" href="{{url('solicitudcotizaciones/versolicitudes/'.$proyecto->id)}}" class="btn btn-success btn-xs"><span class="fa fa-list"></span></a>
                          @elseif( $proyecto->estado == 6 )
                            <a href="{{url('solicitudcotizaciones/versolicitudes/'.$proyecto->id)}}">ver orden</a>
                          @elseif( $proyecto->estado == 8)
                            <a href="{{url('inventarios?proyecto='.$proyecto->id)}}">Ver inventario</a>
                          @endif
                          <button title="Dar de baja al proyecto" class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$proyecto->id.",'proyectos')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        </div>
                        {{ Form::close()}}

                      @endif
                      @if( $estado == 1 )
                        {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                        <div class="btn-group">
                          <a href="{{ url('proyectos/'.$proyecto->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{ url('presupuestos/crear/'.$proyecto->id) }}" class="btn btn-success btn-xs"><span class="fa fa-balance-scale"></span></a>
                          <a href="{{ url('proyectos/'.$proyecto->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                          <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$proyecto->id.",'proyectos')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        </div>
                        {{ Form::close()}}
                      @endif
                      @if( $estado == 9 )
                        {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                          <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$proyecto->id.",'proyectos')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        {{ Form::close()}}
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <script>
                function cambiar(id){
                  swal({
                    title: '¿Está seguro de enviar el proyecto a cotizar?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'si, continuar!'
                  }).then((result) => {
                    if (result.value) {
                      var token = $('meta[name="csrf-token"]').attr('content');
                      var ruta ="/"+carpeta()+"/public/presupuestos/cambiar";
                      $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: ruta,
                        headers: {'X-CSRF-TOKEN':token},
                        data:{id},
                        success : function(msj){
                          console.log(msj);
                          if(msj.mensaje == "exito"){
                            window.location.href = "/"+carpeta()+"/public/proyectos";
                            console.log(msj);
                            toastr.success('Proyecto listo para cotizar');
                          }else{
                            toastr.error('Ocurrió un error');
                          }

                        },
                        error: function(){
                          toastr.error('Ocurrió un error');
                        }
                      });

                    }
                  })
                }
              </script>
            </div>
          </div>
        </div>
</div>
@endsection
