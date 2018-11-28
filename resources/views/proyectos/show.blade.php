@extends('layouts.app')

@section('migasdepan')
<h1>Ver datos del proyecto:</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Ver proyecto</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos del Proyecto </div>
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <th>Nombre del proyecto</th>
                      <th>{{$proyecto->nombre}}</th>
                    </tr>
                    <tr>
                      <th>Justificación</th>
                      <th>{{$proyecto->motivo}}</th>
                    </tr>
                    <tr>
                      <th>Dirección donde se ejecutará</th>
                      <th>{{$proyecto->direccion}}</th>
                    </tr>
                    <tr>
                      <th>Origen de los fondos:</th>
                      <td>
                        @foreach($proyecto->fondo as $fondo)
                        <tr>
                            <td>{{$fondo->fondocat->categoria}}</td>
                            <td>${{number_format($fondo->monto,2)}}</td>
                        </tr>
                        @endforeach
                      </td>
                    </tr>
                    <tr>
                      <th>Monto total</th>
                      <th>${{number_format($proyecto->monto,2)}}</th>
                    </tr>
                    <tr>
                      <th>Fecha de inicio</th>
                      <th>{{$proyecto->fecha_inicio->format('l d')}} de {{$proyecto->fecha_inicio->format('F Y')}}</th>
                    </tr>
                    <tr>
                      <th>Fecha de finalización</th>
                      <th>{{$proyecto->fecha_fin->format('l d')}} de {{$proyecto->fecha_fin->format('F Y')}}</th>
                    </tr>
                    <tr>
                      <th>Monto de Desarrollo</th>
                      <th>{{$proyecto->monto_desarrollo}}</th>
                    </tr>
                    <tr>
                      <th>Beneficiarios</th>
                      <th>{{$proyecto->beneficiarios}}</th>
                    </tr>
                  </table>
                  <br>
                  @if($proyecto->pre)
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-condensed">
                      <thead>
                        <tr>
                          <th>N°</th>
                          <th>DESCRIPCIÓN</th>
                          <th>UNIDAD DE MEDIDA</th>
                          <th>CANTIDAD</th>
                          <th>PRECIO UNITARIO</th>
                          <th>SUBTOTAL</th>
                          <td></td>
                          <?php $contador=0; $total=0.0 ?>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($proyecto->presupuesto as $presupuesto)
                          <tr>
                            <td colspan="7">ÍTEM {{$presupuesto->categoria->item}} {{$presupuesto->categoria->nombre_categoria}}</td>
                          </tr>
                          @foreach($presupuesto->presupuestodetalle as $detalle)
                        <tr>
                          <?php $contador++;
                            $total=$total+$detalle->cantidad*$detalle->preciou;?>
                          <td>{{$contador}}</td>
                          <td>{{$detalle->catalogo->nombre}}</td>
                          <td>{{$detalle->catalogo->unidad_medida}}</td>
                          <td>{{$detalle->cantidad}}</td>
                          <td>${{number_format($detalle->preciou,2)}}</td>
                          <td>${{number_format($detalle->cantidad*$detalle->preciou,2)}}</td>
                          <td>
                              {!! Form::open(['method' => 'DELETE', 'route' => ['presupuestodetalles.destroy', $detalle->id]]) !!}
                              <div class="btn-group">
                                <a class="btn btn-warning btn-xs" href="{{url('presupuestodetalles/'.$detalle->id.'/edit')}}"><span class="glyphicon glyphicon-edit"></span></a>
                                <button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>
                              {{ Form::close() }}
                          </td>
                        </tr>
                          @endforeach
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="5">TOTAL</th>
                          <th>${{number_format($total,2)}}</th>
                          <th></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                @endif
                      <a href="{{ url('proyectos/'.$proyecto->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
