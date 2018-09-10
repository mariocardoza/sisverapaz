<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SisVerapaz</title>
  <style>

    @page { margin: 140px 50px; }
    #content { top: -125px; bottom: auto;  }
    #header { position: fixed; left: 0px; top: -100px; right: 0px; height: 100px; text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; text-align: center }
    #footer .page:after { content: counter(page); }
    #comparativo th{font-size: 80%;}
    #comparativo td{font-size: 70%;}
  </style>
</head>
<body>
@yield('reporte')
</body>
</html>
