<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boletas</title>
    <link type="text/css" media="all" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @foreach ($planillas as $p)
            <div class="col-sm-4">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">{{$p->empleado->nombre}}</div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <td class="text-center" colspan="3"><strong>DUI:</strong> {{$p->empleado->dui}}</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="3"><strong>NIT:</strong> {{$p->empleado->nit}}</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="3"><strong>Salario:</strong> ${{number_format($p->empleado->detalleplanilla->salario,2)}}</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="3"><strong>Salario a pagar:</strong> ${{number_format(App\Planilla::total_fila($p->id),2)}}</td>
                            </tr>
                            <tr>
                                <td class="" colspan="2"><strong>Banco:</strong> {{$p->empleado->banco->nombre}}</td>
                                <td class="" colspan="1"><strong>N° cuenta:</strong> {{$p->empleado->num_cuenta}}</td>
                            </tr>
                            
                            <tr>
                                <td class="text-center" colspan="3"><strong>Retenciones empleado:</strong></td>
                            </tr>

                            <tr>
                                <td>ISSS: ${{number_format($p->issse,2)}}</td>
                                <td>AFP: ${{number_format($p->afpe,2)}}</td>
                                <td>I/Renta: ${{number_format($p->renta,2)}}</td>
                            </tr>
                            <tr>
                                <td>N° ISSS: {{$p->empleado->num_seguro_social}}</td>
                                <td>N° AFP: {{$p->empleado->num_afp}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="3"><strong>Descuentos empleado:</strong></td>
                            </tr>
                            @if($p->prestamos>0)
                            <tr>
                                <th class="text-center" colspan="3">Préstamos</th>
                            </tr>
                            <tr>
                                <th>Banco</th>
                                <th>N° de cuenta</th>
                                <th>Cuota</th>
                            </tr>
                            @foreach ($p->empleado->prestamo_vigente as $presta)
                            <tr>
                                <td>{{$presta->banco->nombre}}</td>
                                <td>{{$presta->numero_de_cuenta}}</td>
                                <td>${{number_format($presta->cuota,2)}}</td>
                            </tr>
                            @endforeach
                            @endif
                            <tr>
                                <td class="text-center" colspan="3"><strong>Aportación por parte de la alcaldía:</strong></td>
                            </tr>
                            <tr>
                                <td>ISSS: ${{number_format($p->isssp,2)}}</td>
                                <td>AFP: ${{number_format($p->afpp,2)}}</td>
                                <td>INSAFORP: ${{number_format($p->insaforpp,2)}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>