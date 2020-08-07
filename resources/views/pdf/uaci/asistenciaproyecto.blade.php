<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control de asistencia </title>
    <link type="text/css" media="all" rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <style>
    
        @page { margin: 120px 50px; }
        #content { top: -120px; bottom: auto;  }
        #header { position: fixed; top: -100px; }
        #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 100px; text-align: center }
        #footer .page:after { content: counter(page); }
      
      </style>
</head>
<body>
    <header>
        <div class="row" id="header">
            <div class="col-xs-1">
                <img  src="{{asset('img/escudo.png')}}" width="80px" height="100px" alt="">
            </div>
            <div class="col-xs-9">
              
                <div class="row">
                  <div  class="text-center " style="color:#155CC2;font: 180% sans-serif;">ALCALDÍA MUNICIPAL DE VERAPAZ</div> 
                
                    <div class="text-center " style="font-size:13px;color:#155CC2;" >UNIDAD DE ADQUISICIONES Y CONTRATACIONES INSTITUCIONALES</div>
                
                    <div class="text-center " style="color:#155CC2;"> - UACI - </div >
                      <br>
                    <div style="border: 1px solid;" class="text-center">{!! $tipo !!}</div>
        
                </div>
      
            </div>
            <div class="col-xs-1">
                <img src="{{asset('img/escudoes.gif')}}" class="" width="80px" height="90px" alt="escudo El Salvador">
            </div>
          </div>
    </header>
    <br><br>
    <div id="content">
        <table width="100%" rules="all" >
            <thead>
                <tr>
                    <th width="10px" rowspan="2">N°</th>
                    <th rowspan="2">Nombre</th>
                    <th colspan="14" class="text-center">Día</th>
                </tr>
                <tr>
                    @for($i=0;$i<14;$i++)
                    <th width="40px">{{$i+1}}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($proyecto->detalleplanilla as $i => $empleado)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$empleado->empleado->nombre}}</td>
                        @for($i=0;$i<14;$i++)
                        <td></td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>