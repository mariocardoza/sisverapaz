@extends('layouts.app')

@section('migasdepan')
<h1>
Ver detalle del presupuesto
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/presupuestos?proyecto='.$presupuesto->proyecto->id) }}"><i class="fa fa-dashboard"></i> Presupuestos</a></li>
        <li class="active">Detalle del presupuesto</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Presupuesto </div>
                <div class="panel-body">
                <br>
                <a class="btn btn-success" href="{{url('presupuestodetalles/create/'.$presupuesto->id)}}">agregar</a>
                  <table class="table">
                    <tbody>
                      <tr>
                        <th>Nombre del proyecto</th>
                        <td>{{$presupuesto->proyecto->nombre}}</td>
                      </tr>
                      <tr>
                        <th>Año de ejecución</th>
                        <td>{{$presupuesto->created_at->format('Y')}}</td>
                      </tr>
                      <tr>
                        <th>Monto del presupuesto</th>
                        <td>${{number_format($presupuesto->total,2)}}</td>
                      </tr>
                      <tr>
                        <th>Costo de supervisión</th>
                        <td>${{number_format($presupuesto->total*0.10,2)}}</td>
                      </tr>
                      <tr>
                        <th>Monto total</th>
                        <td>${{number_format($presupuesto->total+($presupuesto->total*0.10),2)}}</td>
                      </tr>
                    </tbody>
                  </table>


                        <div class="table-responsive">
                          <table class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                              <tr>
                                <th>N°</th>
                                <th>Categoría</th>
                                <th>Descripción</th>
                                <th>Unidad de medida</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Subtotal</th>
                                <td></td>
                                <?php $contador=0; ?>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($presupuesto->presupuestodetalle as $detalle)
                              <tr>
                                <?php $contador++; ?>
                                <td>{{$contador}}</td>
                                <td>{{$presupuesto->categoria->item}} {{$presupuesto->categoria->nombre_categoria}}</td>
                                <td>{{$detalle->catalogo->nombre}}</td>
                                <td>{{$detalle->catalogo->unidad_medida}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td>${{number_format($detalle->preciou,2)}}</td>
                                <td>${{number_format($detalle->cantidad*$detalle->preciou,2)}}</td>
                                <td>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['presupuestodetalles.destroy', $detalle->id]]) !!}
                                    <div class="btn-group">
                                      <a class="btn btn-warning btn-xs" href="{{url('presupuestodetalles/'.$detalle->id.'/edit')}}"><span class="glyphicon glyphicon-edit"></span></a>
                                      <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                                      </div>
                                    {{ Form::close() }}
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
