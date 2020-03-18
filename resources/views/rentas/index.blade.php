@extends('layouts.app')

@section('migasdepan')
<h1>
	Impuesto/renta
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/cuentas') }}"><i class="fa fa-home"></i>Inicio</a></li>
	<li class="active">Inpuesto/renta</li> </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                <p>
                    Esta sección es para modificar los porcentajes según los trabamos y los excesos para el cálculo del impuesto sobre la renta de los empleados.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-12"><label for="" class="text-center"> --- Mensual --- </label></div><hr>
                    <div class="col-md-2"><label for="">Tipo - Tramo</label></div>
                    <div class="col-md-2"><label for="Desde">Desde</label></div>
                    <div class="col-md-2"><label for="">Hasta</label></div>
                    <div class="col-md-2"><label for="">Exceso</label></div>
                    <div class="col-md-1"><label for="">Porcentaje</label></div>
                    <div class="col-md-2"><label for="">Cuota fija</label></div>
                    <div class="col-md-1"></div>
                    <br><br>
                    @foreach ($rentas as $index => $r)
                    @if($r->tipo_pago == 'Mensual')
                        <div class="col-md-2">
                            <label for="">{{$r->tipo_pago}} - {{$r->tramo}}</label>
                        </div>
                        <div class="col-md-2">
                        <input type="number" name="desde" class="form-control {{$index}}desde" value="{{$r->desde}}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="hasta" class="form-control {{$index}}hasta" value="{{$r->hasta}}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="exceso" class="form-control {{$index}}exceso" value="{{$r->exceso}}">
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="porcentaje" class="form-control {{$index}}porcentaje" value="{{$r->porcentaje}}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="couta" class="form-control {{$index}}cuota" value="{{$r->cuota_fija}}">
                        </div>
                        <div class="col-md-1">
                            <button data-id="{{$r->id}}" data-fila="{{$index}}" class="btn btn-success cambiar"><i class="fa fa-refresh"></i></button>
                        </div>
                        <br><hr>
                    @endif
                    @endforeach
                        <br>

                    <div class="col-md-12"><label for="" class="text-center"> --- Quincenal --- </label></div><hr>
                    <div class="col-md-2"><label for="">Tipo - Tramo</label></div>
                    <div class="col-md-2"><label for="Desde">Desde</label></div>
                    <div class="col-md-2"><label for="">Hasta</label></div>
                    <div class="col-md-2"><label for="">Exceso</label></div>
                    <div class="col-md-1"><label for="">Porcentaje</label></div>
                    <div class="col-md-2"><label for="">Cuota fija</label></div>
                    <div class="col-md-1"></div>
                    <br><br>
                    @foreach ($rentas as $index => $r)
                    @if($r->tipo_pago == 'Quincenal')
                        <div class="col-md-2">
                            <label for="">{{$r->tipo_pago}} - {{$r->tramo}}</label>
                        </div>
                        <div class="col-md-2">
                        <input type="number" name="desde" class="form-control {{$index}}desde" value="{{$r->desde}}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="hasta" class="form-control {{$index}}hasta" value="{{$r->hasta}}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="exceso" class="form-control {{$index}}exceso" value="{{$r->exceso}}">
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="porcentaje" class="form-control {{$index}}porcentaje" value="{{$r->porcentaje}}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="couta" class="form-control {{$index}}cuota" value="{{$r->cuota_fija}}">
                        </div>
                        <div class="col-md-1">
                            <button data-id="{{$r->id}}" data-fila="{{$index}}" class="btn btn-success cambiar"><i class="fa fa-refresh"></i></button>
                        </div>
                        <br><hr>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(e){
        //modificar tramo
        $(document).on("click",".cambiar",function(e){
            e.preventDefault();
            modal_cargando();
            var id=$(this).attr("data-id");
            var fila=$(this).attr("data-fila");
            var desde=$("."+fila+'desde').val();
            var hasta=$("."+fila+'hasta').val();
            var exceso=$("."+fila+'exceso').val();
            var porcentaje=$("."+fila+'porcentaje').val();
            var cuota_fija=$("."+fila+'cuota').val();
            console.log("Desde: "+desde);
            console.log("hasta: "+hasta);
            console.log("exceso: "+exceso);
            console.log("porcentaje: "+porcentaje);
            console.log("cuota: "+cuota_fija);
            $.ajax({
                url:'rentas/'+id,
                type:'PUT',
                dataType:'json',
                data:{desde,hasta,exceso,porcentaje,cuota_fija},
                success: function(json){
                    if(json[0]==1){
                        toastr.success("Porcentajes modificados con éxito");
                        location.reload();
                    }else{
                        toastr.error("Ocurrió un error");
                        swal.closeModal();
                    }
                },error: function(error){
                    toastr.error("Ocurrió un error");
                        swal.closeModal();
                }
            });
        });
    });
</script>
@endsection