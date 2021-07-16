@extends('layouts.app')

@section('migasdepan')
<h1>
        Detalles
        <small>Control de detalles Cotizaciones</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/detallecotizaciones') }}"><i class="fa fa-dashboard"></i> Detalles</a></li>
        <li class="active">Listado de detalles</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p></p>
              <div class="btn-group pull-right">
                <a href="{{ url('/detallecotizaciones/create') }}" class="btn btn-success"><span class="fa fa-plus-circle"></span></a>
                <a href="{{ url('/detallecotizaciones?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/detallecotizaciones?estado=2') }}" class="btn btn-primary">Papelera</a>
              </div>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>Id</th>
                  <th>Cotización</th>
                  <th>Unidad</th>
                  <th>Cantidad</th>
                  <th>Precio unitario</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($detallecotizaciones as $detallecotizacion)
                  <tr>
                    <td>{{ $detallecotizacion->id }}</td>
                    <td>{{ $detallecotizacion->cotizacion_id }}</td>
                    <td>{{ $detallecotizacion->unidad_id }}</td>
                    <td>{{ $detallecotizacion->cantidad }}</td>
                    <td>{{ $detallecotizacion->precio_unitario }}</td>
                    <td>
                            @if($estado == 1 || $estado == "")
                                {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                <a href="{{ url('detallecotizaciones/'.$detallecotizacion->id) }}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                                <a href="{{ url('/detallecotizaciones/'.$detallecotizacion->id.'/edit') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                <button class="btn btn-danger" type="button" onclick={{ "baja(".$detallecotizacion->id.")" }}><span class="fa fa-thumbs-o-down"></span></button>
                                {{ Form::close()}}
                            @else
                                {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                                <button class="btn btn-success" type="button" onclick={{ "alta(".$detallecotizacion->id.")" }}><span class="fa fa-thumbs-o-up"></span></button>
                                {{ Form::close()}}
                             @endif
                        </td>
                  </tr>
                  @endforeach 
                </tbody>
              </table>
                <script>
                    function baja(id)
                    {
                        swal({
                            title: 'Motivo dar de baja',
                            input: 'text',
                            showCancelButton: true,
                            confirmButtonText: 'Dar de baja',
                            showLoaderOnConfirm: true,
                            preConfirm: function (text) {
                                return new Promise(function (resolve, reject) {
                                    setTimeout(function() {
                                        if (text === '') {
                                            reject('Debe ingresar el motivo')
                                        } else {
                                            resolve()
                                        }
                                    }, 2000)
                                })
                            },
                            allowOutsideClick: false
                        }).then(function (text) {
                            var dominio = window.location.host;
                            var form = $(this).parents('form');
                            $('#baja').attr('action','http://'+dominio+'/alcaldia/public/detallecotizaciones/baja/'+id+'+'+text);
                            //document.getElmentById('baja').submit();
                            $('#baja').submit();
                            swal({
                                type: 'success',
                                title: 'Se dio de baja',
                                html: 'Submitted motivo: ' + text
                            })
                        });
                    }

                    function alta(id)
                    {
                        swal({
                            title: 'Dar de alta',
                            showCancelButton: true,
                            confirmButtonText: 'Dar de alta',
                            showLoaderOnConfirm: true,
                            allowOutsideClick: false
                        }).then(function () {
                            var dominio = window.location.host;
                            var form = $(this).parents('form');
                            $('#alta').attr('action','http://'+dominio+'/alcaldia/public/detallecotizaciones/alta/'+id);
                            $('#alta').submit();
                            swal({
                                type: 'success',
                                title: 'Se dio de alta',
                                html: 'Submitted motivo: '
                            })
                        });
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

