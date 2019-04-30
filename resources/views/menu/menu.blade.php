<ul class="sidebar-menu">
        <li class="header">Menú Principal</li>
        <li class="{{Request::is('/home') ? 'activo' : null}}"><a href="{{url('/home')}}">Página de inicio</a></li>
        @if(Auth()->user()->hasRole('admin'))
        <li class="treeview ">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Bitacora</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="{{ url('/bitacoras/general') }}"><i class="fa fa-circle-o"></i> Ver Bitácora</a></li>
          </ul>
        </li>
        <li class="treeview {{ Route::currentRouteName() == 'usuarios.index' ? 'active':null}} {{ Route::currentRouteName() == 'usuarios.create' ? 'active':null}}">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('/usuarios/create') ? 'activo' : null }}"><a href="{{ url('/usuarios/create') }}"><i class="fa fa-circle-o"></i> Registrar Usuarios</a></li>
            <li class="{{ Request::is('/usuarios') ? 'activo' : null }}"><a href="{{ url('/usuarios') }}"><i class="fa fa-circle-o"></i> Listado de Usuarios</a></li>
          </ul>
        </li>
        <li class="treeview {{ Route::currentRouteName() == 'backups.index' ? 'active':null}}">
          <a href="#">
            <i class="glyphicon glyphicon-hdd"></i><span>Respaldos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="{{ url('/backups') }}"><i class="fa fa-circle-o"></i> Ver Respaldos</a></li>
          </ul>
        </li>
        <li class="treeview {{ Route::currentRouteName() == 'configuraciones.create' ? 'active':null}}">
          <a href="#">
            <i class="glyphicon glyphicon-cog"></i><span>Configuraciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="{{ url('configuraciones') }}"><i class="fa fa-circle-o"></i> Configuraciones generales</a></li>
          </ul>
        </li>
        @endif
        @if(Auth()->user()->hasRole('uaci') || Auth()->user()->hasRole('admin'))
        @include('menu.uaci')
        @endif
        @if(Auth()->user()->hasRole('tesoreria'))
          @include('menu.tesoreria')
        @endif
        @if(Auth()->user()->hasRole('catastro'))
          @include('menu.ryct')
        @endif
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multinivel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
      </ul>
