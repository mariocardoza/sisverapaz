@extends('layouts.app')

@section('migasdepan')
    <h1>
        Unidades Administrativas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de Unidades</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Listado</h3>
                    <div class="btn-group pull-right">
                        <a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                        <a href="{{ url('/unidades?estado=1') }}" class="btn btn-primary">Activos</a>
                        <a href="{{ url('/unidades?estado=2')}}" class="btn btn-primary">Papelera</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="example2">
                        <thead>
                        <th>N°</th>
                        <th>Nombre de la unidad</th>
                        <th>Acciones</th>
                        </thead>
                        <tbody>
                        @foreach($unidades as $key => $unidad)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $unidad->nombre_unidad }}</td>
                                <td>
                                    @if($unidad->estado == 1)
                                    {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                                    <a href="javascript:(0)" id="edit" data-id="{{$unidad->id}}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span></a>
                                    <button class="btn btn-danger" type="button" onclick={{ "baja(".$unidad->id.",'unidades')" }}><span class="glyphicon glyphicon-trash"></span></button>
                                    {{ Form::close()}}
                                    @else
                                    {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                                    <button class="btn btn-success" type="button" onclick={{ "alta(".$unidad->id.",'unidades')"}}><span class="glyphicon glyphicon-trash"></span></button>
                                    {{ Form::close() }}
                                    @endif
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
@endsection

@section('scripts')
<script>
    
</script>
@endsection
