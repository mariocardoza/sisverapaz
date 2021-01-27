<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SisVerapaz</title>
  
  <style>
    
    @page { margin: 50px 20px 5px 30px }
    #content { top: -120px; bottom: auto;  }
    #header { position: fixed; top: -100px; }
    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 120px; text-align: center }
    #footer .page:after { content: counter(page); }
    th{font-size: 60%; height: 15px;}
    td{font-size: 60%; height: 15px;}
  </style>
</head>
<body>
@yield('reporte')
</body>
</html>
