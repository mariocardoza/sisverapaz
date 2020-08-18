<?php setlocale(LC_ALL, 'es_ES'); 
\Carbon\Carbon::setLocale('es'); 
$cons=$construccion;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo</title>
    <style>
        .FRX1_11{
            text-align:left;direction:ltr; font-family: "Arial"; font-size: 12pt; border: 0px none; padding: 0px; margin: 0px;font-weight: normal;color:#000000;background-color:transparent;overflow:hidden; position: absolute;
        }

        .titulo{
            text-align:left;direction:ltr; font-family: "Arial"; font-size: 14pt; border: 0px none; padding: 0px; margin: 0px;font-weight: normal;color:#000000;background-color:transparent;overflow:hidden; position: absolute;
        }  
        .pagado {
            background-image:url("{{ url('img/pagado.png')}}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
</head>
@if($construccion->estado==4)
<body class="pagado">
@else 
<body>
@endif
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(400, 590, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
                
            ');
        }
    </script>
@if($construccion->estado<=3)
    <div class="titulo" style="z-Index:7;left:18%;top:4%;width:50%;height:5%;">Verapaz</div>
    <div class="titulo" style="z-Index:7;left:56%;top:4%;width:50%;height:5%;">{{date("d")}}</div>
    <div class="titulo" style="z-Index:7;left:62%;top:4%;width:50%;height:5%;">{{strftime("%B")}}</div>
    <div class="titulo" style="z-Index:7;left:82%;top:4%;width:50%;height:5%;">{{date("Y")}}</div>
@else
<div class="titulo" style="z-Index:7;left:18%;top:4%;width:50%;height:5%;">Verapaz</div>
    <div class="titulo" style="z-Index:7;left:56%;top:4%;width:50%;height:5%;">{{$construccion->fecha_pago->format("d")}}</div>
    <div class="titulo" style="z-Index:7;left:62%;top:4%;width:50%;height:5%;">{{$construccion->fecha_pago->format("F")}}</div>
    <div class="titulo" style="z-Index:7;left:82%;top:4%;width:50%;height:5%;">{{$construccion->fecha_pago->format("Y")}}</div>
@endif

    <div class="FRX1_11" style="z-Index:7;left:1.93292in;
top:0.96667in;width:1.38542in;height:0.17708in;">${{number_format($construccion->total,2)}}</div>
    <div class="FRX1_11" style="z-Index:7;left:1in;
top:1.26667in;width:2.0in;height:1.17708in;">{{$construccion->contribuyente->nombre}}</div>

<div class="FRX1_11" style="z-Index:7;left:1in;
top:1.86667in;width:1.78542in;height:1.17708in;">{{num_letras(number_format($construccion->total,2))}}</div>

<div class="FRX1_11" style="z-Index:7;left:3in;
top:1.86667in;width:1.58542in;height:1.57708in;">Pago por derecho de construcción</div>


<div class="FRX1_11" style="z-Index:7;left:5in;
top:1.86667in;width:1.58542in;height:1.57708in;">${{number_format($construccion->impuesto,2)}}</div>

<div class="FRX1_11" style="z-Index:7;left:3in;
top:2.96667in;width:1.58542in;height:1.57708in;">{{retornar_porcentaje("fiestas")*100}}% Fiestas</div>

<div class="FRX1_11" style="z-Index:7;left:5in;
top:2.96667in;width:1.58542in;height:1.57708in;">${{number_format($construccion->fiestas,2)}}</div>


<div class="FRX1_11" style="z-Index:7;left:5in;
top:5.96667in;width:1.58542in;height:1.57708in;">${{number_format($construccion->total,2)}}</div>
</body>
</html>