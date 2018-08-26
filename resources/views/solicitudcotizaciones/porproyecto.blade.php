@php
  use App\Categoria;
@endphp
@extends('layouts.app')

@section('migasdepan')
<h1>
        Listado de solicitudes realizadas
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/solicitudcotizaciones') }}"><i class="fa fa-align-right"></i> Solicitudes</a></li>
        <li class="active">Listado de solicitudes</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
              <div class="btn-group pull-right">
                <a href="{{ url('proyectos') }}" class="btn btn-danger" title="Atras"><span class="glyphicon glyphicon-menu-left"></span></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Proyecto</th>
                    <th>Numero de solicitud</th>
                    <th>Categoría</th>
                    <td>Acción</td>
                    <?php $correlativo=0 ?>
                  </tr>
                </thead>
                <tbody>
                   @foreach($proyecto->presupuesto as $pre)
                    <tr>
                      <?php $correlativo++ ?>
                      <td>{{$correlativo}}</td>
                      <td>{{$pre->proyecto->nombre}}</td>
                      <td>{{$pre->presupuestosolicitud->solicitudcotizacion->numero_solicitud}}</td>
                      <td>{{ Categoria::categoria_nombre($pre->presupuestosolicitud->categoria_id)}} </td>
                     <td>
                       @if($pre->presupuestosolicitud->estado==1)
                        @if(now()->format('Y-m-d') <= $pre->presupuestosolicitud->solicitudcotizacion->fecha_limite)
                          <a title="Registrar cotización" href="{{ url('cotizaciones/realizarcotizacion/'.$pre->presupuestosolicitud->solicitudcotizacion->id) }}" class="btn btn-success btn-xs"><span class="fa fa-outdent"></span></a>
                          <a href="{{url('cotizaciones?solicitud='.$pre->presupuestosolicitud->solicitudcotizacion->id)}}">ver</a>
                        @else
                          <a title="Finalizar las cotizaciones" onclick="{{ "cambiar(".$pre->proyecto->id.",".$pre->presupuestosolicitud->id.")" }}" class="btn btn-default btn-xs"><span class="fa fa-check"></span></a>
                        @endif
                     @elseif($pre->presupuestosolicitud->estado==2)
                       <a title="Ver cuadro comparativo" href="{{ url('cotizaciones/ver/'.$pre->presupuestosolicitud->id) }}" class="btn btn-success btn-xs"><span class="fa fa-outdent"></span></a>
                     @elseif($pre->presupuestosolicitud->estado==3)
                       <a title="Registrar orden de compra" href="{{url('ordencompras/realizarorden/'.$pre->presupuestosolicitud->id)}}">crear</a>
                     @endif
                     </td>
                    </tr>

                     @endforeach
                </tbody>
              </table>
              <script>
                function cambiar(idp,idps){
                  alert(idps);
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
                      var ruta ="/"+carpeta()+"/public/solicitudcotizaciones/cambiar";
                      $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: ruta,
                        headers: {'X-CSRF-TOKEN':token},
                        data:{idp,idps},
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
                        error: function(error){
                          toastr.error('Ocurrió un error');
                          console.log(error);
                        }
                      });

                    }
                  })
                }
              </script>
              <div class="pull-right">

              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>
@endsection
