<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SisVerapaz</title>
  <link type="text/css" media="all" rel="stylesheet" href="{{ asset('css/sisverapaz.css') }}">
  <style>
    
    @page { margin: 120px 50px; }
    #content { top: -120px; bottom: auto;  }
    #header { position: fixed; top: -100px; }
    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 120px; text-align: center }
    #footer .page:after { content: counter(page); }
    #comparativo th{font-size: 80%;}
    #comparativo td{font-size: 70%;}
  </style>
</head>
<body>
@yield('reporte')
</body>
</html>
