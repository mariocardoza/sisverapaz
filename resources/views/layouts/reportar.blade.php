<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SisVerapaz</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

@php
  $cod=date("Yisisus");
@endphp
  <link rel="stylesheet" href="{{ asset('css/sisverapaz.css') }}">
  <link rel="stylesheet" type="text/css" media="print" href="{{ asset('css/fullcalendar.print.css')}}">
  <script src="{{ asset('js/sisverapaz.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhvC3rIiMvEM4JUPAl4fG1xNPRKoRnoTg"></script>
  <script src="{{ asset('js/funcionesgenerales.js') }}"></script>
  <script src="{{asset('js/gmaps.min.js')}}"></script>
<style>
  .error{
    color:red;
  }
  .action-btn-wrapper {
    position: relative;
}

.fixed-action-btn.my-custom-btn {
    position: absolute;
    right: 2px;
    top: 25px;
    padding-top: 15px;
    margin-bottom: 0;
    z-index: 2;
}
a.btn-floating.btn-large.red {
    width: 35px;
    height: 35px;
    border-radius: 100%;
    background: #F44336;
    right: 0;
    bottom: 0;
    position: absolute;
    border: none;
    outline: none;
    color: #FFF;
    font-size: 26px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    transition: .3s;
    opacity: 0.5;
    cursor: pointer;
}
a.btn-floating.btn-large.red:hover {
    width: 60px;
    height: 60px;
    border-radius: 100%;
    background: #F44336;
    right: 0;
    bottom: 0;
    position: absolute;
    border: none;
    outline: none;
    color: #FFF;
    font-size: 36px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    transition: .3s;
    opacity: 1;
    cursor: pointer;
}
</style>
</head>
<body class="skin-blue fixed sidebar-mini sidebar-mini-expand-feature">

<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/reportar-alumbrado') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>VZ</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SisVerapaz</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          @if(Auth()->guest())
            @include('layouts.notificaciones.notificacionesUsuario')
          @else
          
        @endif
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('avatars/avatar.jpg') }}" class="user-image" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Visitante </p>
          <a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li class="header">Indicaciones</li>
        <li class=><a href="javascript:void(0);"><span style="font-size: 10px;">1. Haga clic en el boton reportar a la derecha</span></a></li>
        <li class=><a href="javascript:void(0);"><span style="font-size: 10px;">2. Arrastre la imagen de la lámpara <br>hasta donde se aproxime a su ubicación<br>correcta</span></a></li>
        <li class=><a href="javascript:void(0);"><span style="font-size: 10px;">3. Llene la información solicitada</span></a></li>
      </ul>

    </section>
  </aside>
 <!-- aqui comienza el contenido -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    @yield('migasdepan')
    </section>

    <!-- Main content -->
    <section class="content" style="min-height: 545px;">
      <!-- Small boxes (Stat box) -->
    @if(Session::has('mensaje'))
        <?php
          echo ("<script type='text/javascript'>toastr.success('". Session::get('mensaje') ."');</script>");
         ?>
    @endif
    @if(Session::has('info'))
        <?php
          echo ("<script type='text/javascript'>toastr.info('". Session::get('info') ."');</script>");
         ?>
    @endif
    @if(Session::has('error'))
      <?php
        echo ("<script type='text/javascript'>toastr.error('". Session::get('error') ."');</script>");
       ?>
    @endif
    <div class="action-btn-wrapper" style="z-index: 2;">
      <div class="fixed-action-btn my-custom-btn horizontal">
        <a title="Ayuda" id="btn_help" class="btn-floating btn-large red">
            <i class="fa fa-question"></i>
        </a>
    </div>
    </div>
      @yield('content')

    

  


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer hidden-print">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong> &copy; {{date("Y")}} <a target="_blank" href="http://www.ues.edu.sv">Alcaldía Municipal de Verapaz</a>.</strong> Todos los derechos reservados
  </footer>


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@yield('scripts')

 
{{-- {!! Html::script('js/main.js') !!} --}}
</body>
</html>
