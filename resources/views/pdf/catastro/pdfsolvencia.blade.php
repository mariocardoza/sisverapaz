<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SisVerapaz - Solvencia </title>
  <style>
    
    @page { margin: 120px 50px; }
    #content { top: -120px; bottom: auto;  }
    #header { position: fixed; top: -100px; }
    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 120px; text-align: center }
    #footer .page:after { content: counter(page); }
  </style>
</head>
<header>
    <div style="position: fixed; top: -100px;">
        <div class="row">
            <div class="col-xs-1">
                <img  src="{{asset('img/escudo.png')}}" width="80px" height="100px" alt="">
            </div>
            <div class="col-xs-9">
              
                <div class="row">
                    <div  class="text-center " style="color:#155CC2;font: 180% sans-serif;">ALCALDÍA MUNICIPAL DE VERAPAZ</div> 
                
                    <div class="text-center " style="font-size:13px;color:#155CC2;" >REGISTRO Y CONTROL TRIBUTARIO</div>
                </div>
      
            </div>
            <div class="col-xs-1">
                <img src="{{asset('img/escudoes.gif')}}" class="" width="80px" height="90px" alt="escudo El Salvador">
            </div>
          </div>
    </div>
</header>
<body>
    
    
      <div class="">
        <div class="row">
            <div class="col-md-11">
                <div class="">
                    <div class="panel-body">
                      <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <div id="footer">
        <table width="100%">
          <tr>
            <td><center>Calle Pbro. Norberto Marroquín y 1a avenida sur barrio Mercedes, Verapaz, departamento de San Vicente
            TEL:2347-0300 FAX:2396-3012 e-mail: verapaz.uaci@gmail.com</center></td>
          </tr>
          <tr>
            <td><center class="page"> Página </center></td>
          </tr>
        </table>
      </div>
</footer>
</html>

