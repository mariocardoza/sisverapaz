@extends('layouts.app')

@section('migasdepan')
<h1>
        Cementerios
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Listado de cementerios</li>
      </ol>
@endsection

@section('content')
<style>
  .modal {
    position:absolute;
    overflow:scroll;
}
</style>
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3><br>
                <a href="{{ url('cementerios/create') }}" id="nuevo" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Nombre</th>
                  <th>Cantidad puestos a perpetuidad</th>
                  <th>Estado</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($cementerios as $index=> $c)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->maximo }}</td>
                      @if($c->estado==1)
                      <td>
                      <label for="" class="col-md-12 label-primary">Libre</label>
                      </td>
                      @elseif($c->estado==2)
                      <td>
                      <label for="" class="col-md-12 label-danger">LLeno</label>
                      </td>
                      @elseif($c->estado==3)
                      <td>
                      <label for="" class="col-md-12 label-success">Pagada y pendiente de recibo</label>
                      </td>
                      @else
                      <td>
                      <label for="" class="col-md-12 label-success">Disponible</label>
                    </td>
                      @endif
                    
                    <td>
                      <a href="{{ url('cementerios/'.$c->id) }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span></a>
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

@endsection